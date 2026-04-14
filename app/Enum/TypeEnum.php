<?php

namespace App\Enum;

enum TypeEnum: string
{

    case SELFEMPLOYED = 'selfEmployed';
    case LEGALENTITY = 'legalEntity';
    case INDIVIDUALENTREPRENEUR = 'individualEntrepreneur';

    public function toString(): ?string
    {
        return match ($this) {
            self::SELFEMPLOYED => 'Самозанятый',
            self::LEGALENTITY => 'Юридическое лицо',
            self::INDIVIDUALENTREPRENEUR => 'Индивидуальный предприниматель',
        };
    }
    public static function toDB(string $str): ?string
    {
        // для таблицы БД
        return match ($str) {
            'selfEmployed' => 'self_employeds',
            'legalEntity'=> 'legal_entities',
            'individualEntrepreneur' => 'individual_entrepreneurs',
        };
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
     * Проверить, существует ли значение
     */
    public static function isValid(string $value): bool
    {
        return !is_null(self::tryFrom($value));
    }

    /**
     * Получить enum по значению или вернуть null
     */
    public static function fromValue(string $value): ?self
    {
        return self::tryFrom($value);
    }

    /**
     * Получить все значения как массив
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Возвращает название роута для типа "vendor_selfEmployed"
     */
    public static function route(string $value): ?string
    {
        if (self::isValid($value)) {
            return 'vendor_' . self::tryFrom($value)->value;
        }
        return null;
    }


}
