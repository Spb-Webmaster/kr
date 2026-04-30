<?php

namespace App\Http\Controllers\Cabinet\CabinetVendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\CabinetVendor\VendorGalleryImageUploadRequest;
use App\Http\Requests\CabinetVendor\VendorImageUploadRequest;
use App\Http\Requests\CabinetVendor\VendorServiceAddRequest;
use App\Models\OrderPaper;
use Domain\Order\ViewModels\OrderViewModel;
use Domain\Product\ViewModel\ProductViewModel;
use Domain\Vendor\ViewModels\VendorViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Support\Upload\VideoChunkUploader;


class CabinetVendorController extends Controller
{

    /** Страница проверки сертификата */
    public function certificateCheck(): View
    {
        $vendor = VendorViewModel::make()->v(session()->get('v'));
        return view('cabinet.cabinet_vendor.certificate_check', compact('vendor'));
    }

    /** Проверить номер сертификата */
    public function certificateCheckHandle(Request $request): View
    {
        $request->validate(['number' => ['required', 'string', 'max:50']]);

        $vendor = VendorViewModel::make()->v(session()->get('v'));
        $number = trim($request->input('number'));
        $result = OrderViewModel::make()->findCertificateByNumber($number, $vendor->id);

        return view('cabinet.cabinet_vendor.certificate_check', compact('vendor', 'result', 'number'));
    }

    /** Погасить сертификат */
    public function certificateRedeem(Request $request): RedirectResponse
    {
        $request->validate([
            'type' => ['required', 'in:order,order_paper'],
            'id'   => ['required', 'integer', 'min:1'],
        ]);

        $vendor  = VendorViewModel::make()->v(session()->get('v'));
        $success = OrderViewModel::make()->redeemCertificate(
            $request->input('type'),
            (int) $request->input('id'),
            $vendor->id
        );

        if (!$success) {
            flash()->alert('Сертификат не найден или уже погашен.');
            return redirect()->route('cabinet_vendor_certificate_check');
        }

        flash()->info('Сертификат успешно погашен.');
        return redirect()->route('cabinet_vendor_certificate_check');
    }

    public function cabinetVendor():View
    {
        $vendor = VendorViewModel::make()->v(session()->get('v'));
         return view('cabinet.cabinet_vendor.cabinet_vendor', compact('vendor'));
    }

    /** Список услуг */
    public function cabinetVendorServices():View
    {
        $vendor   = VendorViewModel::make()->v(session()->get('v'));
        $products = ProductViewModel::make()->productsByVendor($vendor->id);
        return view('cabinet.cabinet_vendor.services.services', compact('vendor', 'products'));
    }

    /** Добавить услугу — форма */
    public function cabinetVendorServiceAdd():View
    {
        $vendor = VendorViewModel::make()->v(session()->get('v'));
        $formData = ProductViewModel::make()->formData();
        return view('cabinet.cabinet_vendor.services.partial.add', compact('vendor') + $formData);
    }

    /** Сохранить новую услугу */
    public function cabinetVendorServiceStore(VendorServiceAddRequest $request): RedirectResponse
    {
        $vendor = VendorViewModel::make()->v(session()->get('v'));

        $data = $request->validated();

        $categoryIds = $data['categories'] ?? [];
        $tagIds      = $data['tags'] ?? [];
        unset($data['categories'], $data['tags']);

        if (!empty($data['gallery'])) {
            $data['gallery'] = json_decode($data['gallery'], true) ?? [];
        }

        if (isset($data['weather'])) {
            $data['weather'] = strip_tags($data['weather']);
        }

        if (empty($data['price'])) {
            $data['price'] = 0;
        }
        if (empty($data['prices'])) {
            unset($data['prices']);
        }

        $data['vendor_id']  = $vendor->id;
        $data['published']  = 0;
        $data['slug']       = Str::slug($data['title']);

        try {
            $product = ProductViewModel::make()->create($data, $categoryIds, $tagIds);
            $moved   = $this->moveToProductFolder($data, $vendor->id, $product->id);
            $updates = array_filter([
                'img'     => $moved['img'] ?? null,
                'gallery' => $moved['gallery'] ?? null,
                'video'   => $moved['video'] ?? null,
            ]);
            if ($updates) {
                $product->update($updates);
            }
        } catch (\Throwable $th) {
            logErrors($th);
            flash()->alert('Ошибка при сохранении услуги. Попробуйте ещё раз.');
            return redirect()->back()->withInput();
        }

        flash()->info('Услуга успешно добавлена и отправлена на проверку.');
        return redirect()->route('cabinet_vendor_services');
    }

    /** Редактировать услугу — форма */
    public function cabinetVendorServiceEdit(int $id): View
    {
        $vendor   = VendorViewModel::make()->v(session()->get('v'));
        $product  = ProductViewModel::make()->productOfVendor($vendor->id, $id);
        $formData = ProductViewModel::make()->formData();
        return view('cabinet.cabinet_vendor.services.partial.edit', compact('vendor', 'product') + $formData);
    }

    /** Сохранить изменения услуги */
    public function cabinetVendorServiceUpdate(VendorServiceAddRequest $request, int $id): RedirectResponse
    {
        $vendor  = VendorViewModel::make()->v(session()->get('v'));
        $product = ProductViewModel::make()->productOfVendor($vendor->id, $id);

        $data = $request->validated();

        $categoryIds = $data['categories'] ?? [];
        $tagIds      = $data['tags'] ?? [];
        unset($data['categories'], $data['tags']);

        if (empty($data['price'])) {
            $data['price'] = 0;
        }
        if (empty($data['prices'])) {
            unset($data['prices']);
        }

        if (!empty($data['gallery'])) {
            $data['gallery'] = json_decode($data['gallery'], true) ?? [];
        }

        if (isset($data['weather'])) {
            $data['weather'] = strip_tags($data['weather']);
        }

        $hasPapers = OrderPaper::where('product_id', $product->id)
            ->where('vendor_id', $vendor->id)
            ->exists();

        if ($hasPapers) {
            $data['published'] = 0;
        }

        $data['slug'] = Str::slug($data['title']);
        $data         = $this->moveToProductFolder($data, $vendor->id, $product->id);

        try {
            ProductViewModel::make()->update($product, $data, $categoryIds, $tagIds);
        } catch (\Throwable $th) {
            logErrors($th);
            flash()->alert('Ошибка при сохранении услуги. Попробуйте ещё раз.');
            return redirect()->back()->withInput();
        }

        $message = $hasPapers
            ? 'Изменения сохранены. Услуга отправлена на повторную проверку.'
            : 'Изменения сохранены.';

        flash()->info($message);

        if ($request->input('action') === 'save') {
            return redirect()->route('cabinet_vendor_service_edit', $id);
        }

        return redirect()->route('cabinet_vendor_services');
    }

    /** Удалить услугу */
    public function cabinetVendorServiceDelete(int $id): RedirectResponse
    {
        $vendor  = VendorViewModel::make()->v(session()->get('v'));
        $product = ProductViewModel::make()->productOfVendor($vendor->id, $id);

        if ($product->order_papers_count > 0) {
            flash()->alert('Нельзя удалить услугу, для которой выписаны бумажные сертификаты.');
            return redirect()->route('cabinet_vendor_service_edit', $id);
        }

        try {
            ProductViewModel::make()->delete($product);
        } catch (\Throwable $th) {
            logErrors($th);
            flash()->alert('Ошибка при удалении услуги. Попробуйте ещё раз.');
            return redirect()->route('cabinet_vendor_service_edit', $id);
        }

        flash()->info('Услуга удалена.');
        return redirect()->route('cabinet_vendor_services');
    }

    /** Удалить видео услуги */
    public function cabinetVendorServiceDeleteVideo(int $id): JsonResponse
    {
        $vendor  = VendorViewModel::make()->v(session()->get('v'));
        $product = ProductViewModel::make()->productOfVendor($vendor->id, $id);

        if ($product->video) {
            Storage::disk('public')->delete($product->video);
            $product->update(['video' => null]);
        }

        return response()->json(['success' => true]);
    }

    /** Загрузка основного изображения услуги */
    public function uploadImage(VendorImageUploadRequest $request): JsonResponse
    {
        $vendor = VendorViewModel::make()->v(session()->get('v'));
        $path   = Storage::disk('public')->put("images/vendors/{$vendor->id}/temp", $request->file('image'));

        return response()->json([
            'path' => $path,
            'url'  => Storage::url($path),
        ]);
    }

    /** Загрузка изображения в галерею услуги */
    public function uploadGalleryImage(VendorGalleryImageUploadRequest $request): JsonResponse
    {
        $vendor = VendorViewModel::make()->v(session()->get('v'));
        $path   = Storage::disk('public')->put("images/vendors/{$vendor->id}/temp", $request->file('image'));

        return response()->json([
            'path' => $path,
            'url'  => Storage::url($path),
        ]);
    }

    /**
     * Принимает один чанк (фрагмент) видеофайла от браузера и сохраняет его.
     *
     * Как работает процесс целиком:
     *   1. Браузер делит большой файл на маленькие части (чанки) по 5 МБ.
     *   2. Каждый чанк отправляется отдельным POST-запросом на этот метод.
     *   3. Метод проверяет данные, дописывает чанк во временный файл.
     *   4. Когда пришёл последний чанк — временный файл перемещается
     *      в постоянную папку пользователя, путь возвращается браузеру.
     *   5. Браузер записывает путь в скрытый input и отправляет основную форму.
     */
    public function uploadVideoChunk(Request $request): JsonResponse
    {
        // Валидация входящих данных:
        // - chunk       — сам файл-фрагмент, допустимые форматы видео, макс. 10 МБ на чанк
        // - chunkIndex  — порядковый номер чанка, начиная с 0
        // - totalChunks — общее количество чанков (сколько частей у файла)
        // - filename    — оригинальное имя файла (нужно для временного хранения)
        $request->validate([
            'chunk'       => ['required', 'file', 'max:10240'],
            'chunkIndex'  => ['required', 'integer', 'min:0'],
            'totalChunks' => ['required', 'integer', 'min:1'],
            'filename'    => ['required', 'string', 'max:255', 'regex:/\.(mp4|mov|avi|webm)$/i'],
        ]);

        // Получаем текущего вендора(продавца) из сессии — его ID используется
        // как имя папки назначения: storage/app/public/users/{id}/
        $vendor = VendorViewModel::make()->v(session()->get('v'));

        // Приводим числовые параметры к int, чтобы исключить сравнение строк
        $chunkIndex  = (int) $request->input('chunkIndex');
        $totalChunks = (int) $request->input('totalChunks');

        // Очищаем имя файла: оставляем только буквы, цифры, точки и дефисы.
        // Это защита от path traversal (например, имя "../../etc/passwd" станет безопасным)
        $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $request->input('filename'));

        // Создаём экземпляр загрузчика, привязанный к текущей сессии.
        // Идентификатор сессии используется как уникальное имя временной папки,
        // чтобы у разных пользователей, загружающих одновременно, не было конфликтов.
        $uploader = VideoChunkUploader::make(session()->getId());

        // Дописываем текущий чанк в конец временного файла (FILE_APPEND внутри)
        $uploader->writeChunk($request->file('chunk'), $filename);

        // Если это ещё не последний чанк — сообщаем браузеру продолжать отправку
        if ($chunkIndex + 1 < $totalChunks) {
            return response()->json(['done' => false]);
        }

        // Все чанки получены — собираем файл: перемещаем из временной папки
        // в постоянную storage/app/public/users/{vendor_id}/
        // Метод возвращает относительный путь, например: users/1/video_abc123.mp4
        $path = $uploader->assemble($filename, "video/vendors/{$vendor->id}/temp");

        // Сообщаем браузеру, что загрузка завершена, и передаём путь к файлу.
        // Браузер запишет этот путь в скрытый input[name="video"] формы.
        return response()->json([
            'done' => true,
            'path' => $path,
        ]);
    }

    /** Переместить файлы из temp в постоянную папку продукта */
    private function moveToProductFolder(array $data, int $vendorId, int $productId): array
    {
        $imgDir   = "images/vendors/{$vendorId}/{$productId}";
        $videoDir = "video/vendors/{$vendorId}/{$productId}";

        if (!empty($data['img']) && str_contains((string) $data['img'], '/temp/')) {
            $new         = "{$imgDir}/" . basename($data['img']);
            Storage::disk('public')->move($data['img'], $new);
            $data['img'] = $new;
        }

        if (!empty($data['gallery']) && is_array($data['gallery'])) {
            $data['gallery'] = array_map(function ($row) use ($imgDir) {
                $img = $row['json_gallery_text'] ?? null;
                if ($img && str_contains((string) $img, '/temp/')) {
                    $new                      = "{$imgDir}/" . basename($img);
                    Storage::disk('public')->move($img, $new);
                    $row['json_gallery_text'] = $new;
                }
                return $row;
            }, $data['gallery']);
        }

        if (!empty($data['video']) && str_contains((string) $data['video'], '/temp/')) {
            $new           = "{$videoDir}/" . basename($data['video']);
            Storage::disk('public')->move($data['video'], $new);
            $data['video'] = $new;
        }

        return $data;
    }
}
