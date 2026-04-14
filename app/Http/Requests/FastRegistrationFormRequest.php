<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class FastRegistrationFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->guest();
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'min:1', 'max:255'],
            'email'    => ['required', 'email', 'email:dns', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => str(request('email'))->squish()->lower()->value()
        ]);
    }

    public function messages(): array
    {
        return [
            'username.required'  => 'Необходимо ввести имя.',
            'username.min'       => 'Длина имени мин. :min.',
            'username.max'       => 'Длина имени макс. :max.',
            'email.required'     => 'Email обязателен.',
            'email.email'        => 'Введите корректный email.',
            'email.unique'       => 'Этот email уже зарегистрирован.',
            'password.required'  => 'Пароль обязателен.',
            'password.confirmed' => 'Введённые пароли не совпадают.',
            'password.min'       => 'Длина пароля мин. :min.',
        ];
    }
}
