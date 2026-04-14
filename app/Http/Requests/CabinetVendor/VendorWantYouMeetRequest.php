<?php

namespace App\Http\Requests\CabinetVendor;

use App\Enum\TypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VendorWantYouMeetRequest  extends FormRequest

{
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', 'in:' . implode(',', TypeEnum::values())],
            'username' => ['required', 'string', 'min:1', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'string', 'min:5'],

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
            'phone.min' => 'Длина номера телефона недостаточная.',
            'email.required' => 'Email обязателен.',
            'email.min' => 'Длина email мин. :min.',
            'email.max' => 'Длина email макс. :max.',
            'type.in' => 'Выберите корректный тип продавца. Допустимые значения: ' .
                implode(', ', array_map(fn($t) => $t->toString(), TypeEnum::cases())),
        ];
    }
}
