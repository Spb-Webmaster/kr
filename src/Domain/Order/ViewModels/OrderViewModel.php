<?php

namespace Domain\Order\ViewModels;

use App\Enum\CertificateStatus;
use App\Models\Order;
use App\Models\OrderPaper;
use Domain\Order\DTOs\OrderDto;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Makeable;

class OrderViewModel
{
    use Makeable;

    public function create(array $extra, $request = null): ?Model
    {
        $extra['number'] = $this->generateUniqueNumber();
        $dto = OrderDto::formRequest($request->merge($extra));
        return Order::create($dto->toArray());
    }

    public function findCertificateByNumber(string $number, int $vendorId): ?array
    {
        $order = Order::where('number', $number)
            ->where('vendor_id', $vendorId)
            ->with('product')
            ->first();

        if ($order) {
            return ['type' => 'order', 'model' => $order];
        }

        $orderPaper = OrderPaper::where('number', $number)
            ->where('vendor_id', $vendorId)
            ->with('product')
            ->first();

        if ($orderPaper) {
            return ['type' => 'order_paper', 'model' => $orderPaper];
        }

        return null;
    }

    public function redeemCertificate(string $type, int $id, int $vendorId): bool
    {
        $model = $type === 'order'
            ? Order::where('id', $id)->where('vendor_id', $vendorId)->first()
            : OrderPaper::where('id', $id)->where('vendor_id', $vendorId)->first();

        if (!$model) {
            return false;
        }

        $model->update(['certificate_status' => CertificateStatus::Used]);

        return true;
    }

    public function findByNumber(string $number): ?Order
    {
        return Order::where('number', $number)->with('product')->first();
    }

    private function generateUniqueNumber(): string
    {
        do {
            $number = (string) random_int(10_000_000, 99_999_999);
        } while (
            Order::where('number', $number)->exists() ||
            OrderPaper::where('number', $number)->exists()
        );

        return $number;
    }
}
