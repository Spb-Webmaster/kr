<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordFormRequest extends FormRequest
{

    public function authorize(): bool
    {
        return auth()->user()->id;
    }


    public function rules(): array
    {
        return [
            'password' => ['required', 'confirmed', Password::defaults()],
        ];


    }

    public function messages(): array
    {
        return [
            'password.required' => 'Пароль обязателен.',
            'password.min' => 'Длина пароля мин. :min.',
            'password.max' => 'Длина пароля макс. :max.',
            'password.confirmed' => 'Введенные пароли не совпадают.',
        ];
    }
}
