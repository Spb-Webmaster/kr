<?php

namespace App\Http\Requests\CabinetUser;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        if (auth()->check()) {
            return true;
        }

        return false;

    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'min:1', 'max:255'],
            'email' => ['required', 'email', 'email:dns',
                Rule::unique('users')->ignore($this->input('id'), 'id')],
            'address' => ['nullable', 'string', 'min:3', 'max:200'],
            'telegram' => ['nullable', 'string', 'min:2', 'max:256'],
            'max' => ['nullable', 'string', 'min:5', 'max:256'],
            'vk' => ['nullable', 'string', 'min:3', 'max:256'],
            'about_me' => ['nullable', 'string', 'min:3', 'max:1000'],
            'date_birthday' => ['date_format:d.m.Y', 'nullable'], // Правило date_format заменено на date_format:d.m.Y

        ];


    }

    protected function prepareForValidation(): void
    {
        $this->merge(
            [
                'email' => str(request('email'))
                    ->squish()
                    ->lower()
                    ->value(),
                'telegram' => str(request('telegram'))->squish()->lower()->value(),
                'max' => str(request('max'))->squish()->lower()->value(),
                'vk' => str(request('vk'))->squish()->lower()->value(),
                'about_me' => str(request('about_me'))->stripTags('<br></ br><ul><li>')->value(),


            ]
        );
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Необходимо ввести имя.',
            'username.min' => 'Длина имени мин. :min.',
            'username.max' => 'Длина имени макс. :max.',
            'email.required' => 'Email обязателен.',
            'email.unique' => 'Email уже используется в системе.',

            'address.min' => 'Длина адреса не достаточна.',
            'address.max' => 'Длина для адреса слишком велика.',
            'telegram.min' => 'Длина telegram мин. :min.',
            'telegram.max' => 'Длина telegram макс. :max.',
            'max.min' => 'Длина max мин. :min.',
            'max.max' => 'Длина max макс. :max.',
            'vk.min' => 'Длина vk мин. :min.',
            'vk.max' => 'Длина vk макс. :max.',
            'about_me.min' => 'Длина описания минимум :min.',
            'about_me.max' => 'Длина описания макс. :max.',
            'date_birthday.date_format' => 'Не правильный формат даты.',


        ];
    }
}
