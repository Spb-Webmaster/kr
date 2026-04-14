<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoRegistrationFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'min:2', 'max:255'],
            'email'    => ['required', 'email'],
            'phone'    => ['required', 'string'],
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
            'username.required' => 'Необходимо ввести имя.',
            'username.min'      => 'Длина имени мин. :min.',
            'username.max'      => 'Длина имени макс. :max.',
            'email.required'    => 'Email обязателен.',
            'email.email'       => 'Введите корректный email.',
            'phone.required'    => 'Телефон обязателен.',
        ];
    }
}
