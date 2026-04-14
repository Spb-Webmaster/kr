<?php

namespace App\Enum\Moonshine;

enum PaymentNdsEnum :string
{

    case PRESENCE = 'presence';
    case ABSENCE = 'absence';

    public function toString(): ?string
    {
        return match ($this) {
            self::PRESENCE => 'Наличие',
            self::ABSENCE => 'Отсутствие',
        };
    }

    /**
     * Проверить, существует ли значение
     */
    public static function isValid(string $value): bool
    {
        return !is_null(self::tryFrom($value));
    }

    /**
     * Получить массив всех значений в формате key-value
     */
    public static function toArray(): array
    {
        return array_map(function ($case) {
            return [
                'key' => $case->value,
                'value' => $case->toString()
            ];
        }, self::cases());
    }

    /**
     * Получить enum по значению или вернуть null
     */
    public static function fromValue(string $value): string
    {

        if (self::isValid($value)) {
            return self::tryFrom($value)->toString();
        }
        return ' - ';
    }


}
