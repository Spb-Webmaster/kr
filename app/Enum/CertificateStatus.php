<?php

namespace App\Enum;

enum CertificateStatus: string
{
    case Used = 'used';
    case Unused = 'unused';

    public function toString(): ?string
    {
        return match ($this) {
            self::Used => 'Использовался',
            self::Unused => 'Не использовался',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::Used => 'secondary',
            self::Unused => 'gray',
        };
    }

}
