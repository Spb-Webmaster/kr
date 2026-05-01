<?php

namespace App\Http\Controllers;

use App\Event\Order\OrderCreatedEvent;
use App\Models\Order;
use App\Models\Product;
use Domain\Order\ViewModels\OrderViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;
use Symfony\Component\HttpFoundation\Response;

/**
 * Контроллер заказов (покупка сертификатов).
 *
 * Отвечает за:
 * - создание заказа при покупке сертификата на услугу;
 * - отображение страницы заказа;
 * - генерацию PDF-сертификата и скачивание;
 * - отправку сертификата на произвольный e-mail.
 */
class OrderController extends Controller
{
    /**
     * Создать заказ (покупка сертификата).
     *
     * Принимает POST-запрос с формы покупки. Находит услугу по slug,
     * формирует массив $extra с данными покупателя (авторизованный пользователь
     * или гость из сессии) и передаёт его в OrderViewModel для записи в БД.
     * Гостю сохраняет номер заказа в сессию для последующего доступа к нему.
     */
    public function store(Request $request, string $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        // Базовые поля заказа: название услуги и начальный статус (0 = новый)
        $extra = [
            'title'  => $product->title,
            'status' => 0,
        ];

        if (auth()->check()) {
            // Авторизованный пользователь — берём данные из его профиля
            $user = auth()->user();
            $extra['user_id']  = $user->id;
            $extra['username'] = $user->username;
            $extra['email']    = $user->email;
            $extra['phone']    = $user->phone;
        } else {
            // Гость — данные были временно сохранены в сессии на шаге оформления
            $guest = session('guest_order_user', []);
            $extra['username'] = $guest['username'] ?? null;
            $extra['email']    = $guest['email']    ?? null;
            $extra['phone']    = isset($guest['phone']) ? phone($guest['phone']) : null;
            // Очищаем временные данные гостя из сессии после использования
            session()->forget('guest_order_user');
        }

        // Создаём заказ через ViewModel (все запросы в БД — только через ViewModel)
        $order = OrderViewModel::make()->create($extra, $request);

        // Гостю запоминаем номер заказа в сессии для проверки доступа к странице заказа
        if (!auth()->check()) {
            session()->push('guest_orders', $order->number);
        }

        // Загружаем связи продукта для письма
        $product->load('vendor.legalEntity', 'vendor.individualEntrepreneur', 'vendor.selfEmployed', 'city', 'personCount', 'ageRestriction');
        $vendor = $product->vendor;

        if ($vendor?->legalEntity) {
            $vendorName = $vendor->legalEntity->name;
        } elseif ($vendor?->individualEntrepreneur) {
            $vendorName = $vendor->individualEntrepreneur->name;
        } else {
            $vendorName = trim(implode(' ', array_filter([
                $vendor?->surname, $vendor?->username, $vendor?->patronymic,
            ])));
        }

        // Диспатчим событие — генерация PDF и отправка уведомления администратору
        OrderCreatedEvent::dispatch([
            'order_number'  => $order->number,
            'ordered_at'    => $order->created_at->format('d.m.Y H:i'),
            'title'         => $product->title,
            'subtitle'      => $product->subtitle ?? null,
            'product_url'   => route('certificate', ['slug' => $product->slug]),
            'price'         => $order->price ? price($order->price) : null,
            'price_option'  => $order->price_option ?? null,
            'is_registered' => auth()->check(),
            'username'      => $extra['username'] ?? null,
            'email'         => $extra['email'] ?? null,
            'phone'         => isset($extra['phone']) ? format_phone($extra['phone']) : null,
            'vendor_name'    => $vendorName,
            'vendor_phone'   => $vendor?->phone ? format_phone($vendor->phone) : null,
            'vendor_email'   => $vendor?->email ?? null,
            'city'            => $product->city?->title,
            'weather'         => $product->weather ?? null,
            'person_count'    => $product->personCount?->title,
            'age_restriction' => $product->ageRestriction?->title,
            'desc'             => $product->desc ?? null,
            'desc2'            => $product->desc2 ?? null,
            'special_clothing' => $product->special_clothing ?? null,
            'product_address' => $product->address ?? null,
            'buyer_email'     => $extra['email'] ?? null,
        ]);

        return redirect()->route('order.show', ['number' => $order->number]);
    }

    /**
     * Показать страницу заказа.
     *
     * Доступ разрешён только владельцу заказа:
     * - авторизованный пользователь — сверяем user_id;
     * - гость — проверяем наличие номера заказа в его сессии.
     */
    public function show(string $number)
    {
        $order = Order::where('number', $number)->firstOrFail();

        if (auth()->check()) {
            abort_if($order->user_id !== auth()->id(), Response::HTTP_FORBIDDEN);
        } else {
            $guestOrders = session('guest_orders', []);
            abort_if(!in_array($order->number, $guestOrders), Response::HTTP_FORBIDDEN);
        }

        return view('order.order', compact('order'));
    }

    /**
     * Скачать PDF-сертификат.
     *
     * Если PDF уже был сгенерирован и сохранён в storage после создания заказа —
     * отдаём готовый файл. Если файла нет — генерируем на лету через Browsershot.
     */
    public function downloadCertificate(string $number)
    {
        $storedPath = 'pdf/certificate-' . $number . '.pdf';

        if (Storage::disk('public')->exists($storedPath)) {
            return response(Storage::disk('public')->get($storedPath), 200, [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'inline; filename="certificate-' . $number . '.pdf"',
            ]);
        }

        // Fallback: генерация на лету если файл ещё не был сохранён
        $order = Order::where('number', $number)->with(['product', 'vendor'])->firstOrFail();

        $logoPath = storage_path('app/public/images/logo.png');
        $logoDataUrl = file_exists($logoPath)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
            : null;

        $giftBoxPath = storage_path('app/public/images/hapy-box.png');
        $giftBoxDataUrl = file_exists($giftBoxPath)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($giftBoxPath))
            : null;

        $html = view('pdf.certificate', compact('order', 'logoDataUrl', 'giftBoxDataUrl'))->render();

        $pdf = Browsershot::html($html)
            ->setNodeBinary(env('BROWSERSHOT_NODE_PATH', 'node'))
            ->setChromePath(env('BROWSERSHOT_CHROME_PATH', ''))
            ->noSandbox()
            ->emulateMedia('screen')
            ->waitUntilNetworkIdle()
            ->format('A4')
            ->pdf();

        Storage::disk('public')->put($storedPath, $pdf);

        return response($pdf, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="certificate-' . $number . '.pdf"',
        ]);
    }

    /**
     * Отправить сертификат на e-mail.
     *
     * Принимает e-mail из формы (модальное окно на странице заказа)
     * и отправляет PDF-сертификат на указанный адрес.
     *
     * 
     */
    public function sendCertificate(Request $request, string $number)
    {
        $request->validate(['email' => 'required|email']);

        $order = Order::where('number', $number)->firstOrFail();

        // TODO: отправить PDF на $request->email

        return response()->json(['success' => true]);
    }
}
