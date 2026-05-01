<?php

namespace App\Jobs\Order;

use App\Mail\Order\OrderCreatedBuyerMail;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendCertificateJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly string $orderNumber,
        public readonly string $email,
    ) {}

    public function handle(): void
    {
        $order = Order::where('number', $this->orderNumber)
            ->with(['product.city', 'product.personCount', 'product.ageRestriction', 'product.vendor.legalEntity', 'product.vendor.individualEntrepreneur', 'product.vendor.selfEmployed'])
            ->firstOrFail();

        $product = $order->product;
        $vendor  = $product->vendor;

        if ($vendor?->legalEntity) {
            $vendorName = $vendor->legalEntity->name;
        } elseif ($vendor?->individualEntrepreneur) {
            $vendorName = $vendor->individualEntrepreneur->name;
        } else {
            $vendorName = trim(implode(' ', array_filter([
                $vendor?->surname, $vendor?->username, $vendor?->patronymic,
            ])));
        }

        $data = [
            'order_number'    => $order->number,
            'ordered_at'      => $order->created_at->format('d.m.Y H:i'),
            'title'           => $order->title,
            'subtitle'        => $product->subtitle ?? null,
            'price'           => $order->price ? price($order->price) : null,
            'price_option'    => $order->price_option ?? null,
            'city'            => $product->city?->title,
            'weather'         => $product->weather ?? null,
            'person_count'    => $product->personCount?->title,
            'age_restriction' => $product->ageRestriction?->title,
            'desc'            => $product->desc ?? null,
            'desc2'           => $product->desc2 ?? null,
            'special_clothing'=> $product->special_clothing ?? null,
            'product_address' => $product->address ?? null,
            'vendor_name'     => $vendorName,
            'vendor_phone'    => $vendor?->phone ? format_phone($vendor->phone) : null,
            'certificate_url' => asset('storage/pdf/certificate-' . $order->number . '.pdf'),
        ];

        Mail::to($this->email)->send(new OrderCreatedBuyerMail($data));
    }
}
