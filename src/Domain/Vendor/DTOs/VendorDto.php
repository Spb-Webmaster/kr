<?php

namespace Domain\Vendor\DTOs;

use Illuminate\Http\Request;
use Support\Traits\Makeable;

class VendorDto
{

    use Makeable;

    /** Список полей, которые будем сохранять **/
    const FIELDS = [
        'username',  'surname',  'patronymic', 'email', 'phone', 'about_me', 'questionnaire', 'password', 'city_id', 'published'
    ];

    public function __construct(
        public readonly ?string $username,
        public readonly ?string $surname =  ' - ',
        public readonly ?string $patronymic= null,
        public readonly ?string $email,
        public readonly ?string $phone = null,
        public readonly ?string $about_me = null,
        public readonly string $questionnaire,
        public readonly ?string $password,
        public readonly ?int $city_id= null,
        public  ?int $published = 0,
     )
    {

    }


    public static function formRequest(Request $request)
    {
        return self::make( ... $request->only(self::FIELDS));

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
