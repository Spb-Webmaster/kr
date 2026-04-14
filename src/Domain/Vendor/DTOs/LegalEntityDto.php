<?php

namespace Domain\Vendor\DTOs;

use Illuminate\Http\Request;
use Support\Traits\Makeable;

class LegalEntityDto
{
    use Makeable;

    /** Список полей, которые будем сохранять **/
    const FIELDS = [
       'vendor_id', 'name','full_name', 'email', 'phone', 'legal_address',  'address', 'inn', 'kpp', 'ogrn', 'director', 'accountant',  'person_contract', 'bank', 'bik', 'correspondent_account', 'payment_account', 'okved', 'payment_nds', 'taxation_id'
    ];

    public function __construct(
        public readonly ?int $vendor_id,
        public readonly ?string $name,
        public readonly ?string $full_name = null,
        public readonly ?string $email,
        public readonly ?string $phone = null,
        public readonly ?string $legal_address = null,
        public readonly ?string $address = null,
        public readonly ?string $inn = null,
        public readonly ?string $kpp = null,
        public readonly ?string $ogrn = null,
        public readonly ?string $director = null,
        public readonly ?string $accountant = null,
        public readonly ?string $person_contract = null,
        public readonly ?string $bank = null,
        public readonly ?string $bik = null,
        public readonly ?string $correspondent_account = null,
        public readonly ?string $payment_account = null,
        public readonly ?string $okved = null,
        public readonly ?string $payment_nds,
        public readonly ?int $taxation_id = null,

    )
    {

    }

    public static function formRequest(Request $request)
    {
        return self::make( ... $request->only(self::FIELDS));

    }

    public static function model($model)
    {
        return self::make( ... $model->only(self::FIELDS));

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
