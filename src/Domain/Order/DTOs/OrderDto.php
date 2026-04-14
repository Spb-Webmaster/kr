<?php

namespace Domain\Order\DTOs;

use Illuminate\Http\Request;
use Support\Traits\Makeable;

class OrderDto
{
    use Makeable;

    /** Список полей, которые будем сохранять **/
    const FIELDS = [
        'number',
        'title',
        'username',
        'email',
        'phone',
        'price',
        'price_option',
        'status',
        'product_id',
        'user_id',
        'vendor_id',
    ];

    public function __construct(
        public readonly ?string $number,
        public readonly ?string $title,
        public readonly ?string $username,
        public readonly ?string $email,
        public readonly ?string $phone        = null,
        public readonly ?int    $price        = null,
        public readonly ?string $price_option = null,
        public readonly int     $status       = 0,
        public readonly ?int    $product_id   = null,
        public readonly ?int    $user_id      = null,
        public readonly ?int    $vendor_id    = null,
    ) {}

    public static function formRequest(Request $request): self
    {
        $data = $request->only(self::FIELDS);

        // Очищаем цену от пробелов и символов форматирования → integer
        if (isset($data['price'])) {
            $data['price'] = (int) preg_replace('/\D/', '', $data['price']);
        }

        return self::make(...$data);
    }

    /** Формирование массива нужных полей **/
    public function toArray(): array
    {
        $result = [];
        foreach (self::FIELDS as $field) {
            if (isset($this->$field)) {
                $result[$field] = $this->$field;
            }
        }
        return $result;
    }
}
