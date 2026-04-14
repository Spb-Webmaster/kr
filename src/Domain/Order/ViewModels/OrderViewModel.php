<?php

namespace Domain\Order\ViewModels;

use App\Models\Order;
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

    private function generateUniqueNumber(): string
    {
        do {
            $number = (string) random_int(10_000_000, 99_999_999);
        } while (Order::where('number', $number)->exists());

        return $number;
    }
}
