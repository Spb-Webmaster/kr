<?php

namespace App\Jobs\Order;

use App\Mail\Order\OrderCreatedAdminMail;
use App\Mail\Order\OrderCreatedBuyerMail;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;
use Support\Traits\EmailAddressCollector;

class OrderCreatedJob implements ShouldQueue
{
    use Queueable, EmailAddressCollector;

    public function __construct(public readonly array $data)
    {
    }

    public function handle(): void
    {
        $number = $this->data['order_number'];
        $pdfUrl = $this->generateAndStorePdf($number);

        $dataWithUrl = array_merge($this->data, ['certificate_url' => $pdfUrl]);

        Mail::to($this->emails())->send(new OrderCreatedAdminMail($dataWithUrl));

        if (!empty($this->data['buyer_email'])) {
            Mail::to($this->data['buyer_email'])->send(new OrderCreatedBuyerMail($dataWithUrl));
        }
    }

    private function generateAndStorePdf(string $number): string
    {
        $order = Order::where('number', $number)
            ->with(['product', 'vendor'])
            ->firstOrFail();

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

        $filename = 'pdf/certificate-' . $number . '.pdf';
        Storage::disk('public')->put($filename, $pdf);

        return asset('storage/' . $filename);
    }
}
