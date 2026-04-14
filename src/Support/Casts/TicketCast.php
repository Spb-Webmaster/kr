<?php
namespace Support\Casts;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class TicketCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {

       return $value;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {

       // dd($value);
        // Проверяем, что передано массив с серией и номером
        if (!is_array($value)) {
            throw new \InvalidArgumentException("Значение для тикета должно быть массивом");
        }

        // Объединяем серию и номер пробелом
        return implode(' ', [$value['series'], $value['number']]);

    }
}
