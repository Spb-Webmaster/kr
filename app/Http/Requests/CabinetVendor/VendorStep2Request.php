<?php

namespace App\Http\Requests\CabinetVendor;

use App\Enum\TypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VendorStep2Request extends FormRequest

{
    public function rules(): array
    {
        $vendor_sign_up = session()->get(config('site.constants.vendor_sign_up'));

        return [
            'username' => ['required', 'string', 'min:1', 'max:255'],
            'surname' => ['required', 'string', 'min:1', 'max:255'],
            'city_id' => ['required'],
            'patronymic' => ['string', 'max:255', 'nullable'],
            'email' => ['required', 'email', Rule::unique(TypeEnum::toDB($vendor_sign_up['type']))],
            'phone' => ['nullable', 'string', 'min:5'],
            'inn' => ['required', 'string', 'min:3'],
            'bin' => ['nullable', 'string', 'min:3'],
            'name' => ['nullable', 'string', 'min:3'],
            'full_name' => ['nullable', 'string', 'min:3'],
            'legal_address' => ['nullable', 'string', 'min:3', 'max:255'],
            'register_address' => ['nullable', 'string', 'min:3', 'max:255'],
            'address' => ['nullable', 'string', 'min:3', 'max:255'],
            'kpp' => ['nullable', 'string', 'min:3'],
            'ogrn' => ['nullable', 'string', 'min:3'],
            'director' => ['nullable', 'string', 'min:3', 'max:255'],
            'accountant' => ['nullable', 'string', 'min:3', 'max:255'],
            'person_contract' => ['nullable', 'string', 'min:3', 'max:255'],
            'passport_serial' =>['sometimes', 'nullable', 'string',  'max:255'],
            'passport_number' =>['sometimes', 'nullable', 'string',  'max:255'],
            'who_issued' =>['sometimes', 'nullable', 'string',  'max:255'],
            'date_issued' =>['sometimes', 'nullable', 'string',  'max:255'],
            'bank' => ['nullable', 'string', 'min:1', 'max:255'],
            'correspondent_account' => ['nullable', 'string', 'min:6', 'max:25'],
            'payment_account' => ['nullable', 'string', 'min:6', 'max:25'],
            'about_me' => ['sometimes', 'nullable', 'string',  'max:1512'],
/*            'taxation' => ['sometimes', 'required', 'string'],
            'payment_nds' => ['sometimes', 'required', 'string'], */
        ];
    }
    protected function prepareForValidation():void
    {
        $this->merge(
            [
                'email' => str(request('email'))
                    ->squish()
                    ->lower()
                    ->value(),
                'phone' => phone($this->phone),

            ]
        );
    }
    public function messages(): array
    {
        return [
            'username.required' => 'Необходимо ввести имя.',
            'username.min' => 'Длина имени мин. :min.',
            'username.max' => 'Длина имени макс. :max.',

            'surname.required' => 'Необходимо ввести фамилию.',
            'surname.min' => 'Длина фамилии мин. :min.',
            'surname.max' => 'Длина фамилии макс. :max.',
            'city_id.required' => 'Необходимо выбрать город.',

            'email.required' => 'Email обязателен.',
            'email.unique' => 'Email уже используется.',
            'email.min' => 'Длина email мин. :min.',
            'email' => 'Email уже используется.',
            'validation.email' => 'Длина',

            'about_me.max' => 'Длина описания макс. :max.',

            'phone.min' => 'Длина номера телефона недостаточная.',
            'inn.required' => 'Необходимо ввести ИНН.',
            'inn.min' => 'Длина ИИН мин. :min.',
            'bik.min' => 'Длина ИИН мин. :min.',
            'legal_address.min' => 'Длина адреса мин. :min.',
            'legal_address.max' => 'Длина адреса макс. :max.',
            'register_address.min' => 'Длина адреса мин. :min.',
            'register_address.max' => 'Длина адреса макс. :max.',
            'address.min' => 'Длина адреса мин. :min.',
            'address.max' => 'Длина адреса макс. :max.',
            'kpp.min' => 'Длина ИИН мин. :min.',
            'ogrn.min' => 'Длина ИИН мин. :min.',

            'director.min' => 'Длина ФИО директора мин. :min.',
            'director.max' => 'Длина ФИО директора макс. :max.',
            'accountant.min' => 'Длина ФИО бухгалтера  мин. :min.',
            'accountant.max' => 'Длина ФИО бухгалтера макс. :max.',
            'person_contract.min' => 'Длина ФИО (доверенность) мин. :min.',
            'person_contract.max' => 'Длина ФИО (доверенность) макс. :max.',

            'passport_serial.max' => 'Серия паспорта макс. :max.',
            'passport_number.max' => 'Номер паспорта макс. :max.',
            'who_issued.max' => 'Кто выдал макс. :max.',
            'date_issued.max' => 'Когда выдан макс. :max.',

            'bank.min' => 'Наименование банка мин. :min.',
            'bank.max' => 'Наименование банка макс. :max.',
            'correspondent_account.min' => 'Корреспондентский счет мин. :min.',
            'correspondent_account.max' => 'Корреспондентский счет макс. :max.',
            'payment_account.min' => 'Расчетный счет  мин. :min.',
            'payment_account.max' => 'Расчетный счет  макс. :max.',
/*            'taxation.required' => 'Выбрать систему налогообложения.',
            'payment_nds.required' => 'Выбрать уплату НДС.',*/
        ];
    }
}
