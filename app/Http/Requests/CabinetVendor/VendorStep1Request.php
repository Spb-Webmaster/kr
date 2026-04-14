<?php

namespace App\Http\Requests\CabinetVendor;

use App\Enum\TypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VendorStep1Request extends FormRequest

{
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', 'in:' . implode(',', TypeEnum::values())],
            'username' => ['required', 'string', 'min:1', 'max:255'],
            'email' => ['required', 'email', 'email:dns',   Rule::unique('vendors')],
            'password' => ['required', 'confirmed', 'min:5', 'max:25'],
        ];
    }
    protected function prepareForValidation():void
    {
        $this->merge(
            [
                'email' => str(request('email'))
                    ->squish()
                    ->lower()
                    ->value()
            ]
        );
    }
    public function messages(): array
    {
        return [
            'username.required' => 'Необходимо ввести имя.',
            'username.min' => 'Длина имени мин. :min.',
            'username.max' => 'Длина имени макс. :max.',
            'password.required' => 'Пароль обязателен.',
            'password.min' => 'Длина пароля мин. :min.',
            'password.max' => 'Длина пароля макс. :max.',
            'password.confirmed' => 'Введенные пароли не совпадают.',
            'email.required' => 'Email обязателен.',
            'email.min' => 'Длина email мин. :min.',
            'email.max' => 'Длина email макс. :max.',
            'type.in' => 'Выберите корректный тип продавца. Допустимые значения: ' .
                implode(', ', array_map(fn($t) => $t->toString(), TypeEnum::cases())),
        ];
    }
}
