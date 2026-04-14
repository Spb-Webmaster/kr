<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FastLoginFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->guest();
    }

    public function rules(): array
    {
        return [
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
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
            'email.required'    => 'Email обязателен.',
            'email.email'       => 'Введите корректный email.',
            'password.required' => 'Пароль обязателен.',
        ];
    }
}
