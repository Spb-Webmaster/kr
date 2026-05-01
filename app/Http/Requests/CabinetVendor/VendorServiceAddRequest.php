<?php

namespace App\Http\Requests\CabinetVendor;

use Illuminate\Foundation\Http\FormRequest;

class VendorServiceAddRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'              => ['required', 'string', 'max:255'],
            'subtitle'           => ['nullable', 'string', 'max:255'],
            'desc'               => ['nullable', 'string'],
            'desc2'              => ['nullable', 'string'],
            'price'              => ['nullable', 'integer', 'min:0'],
            'prices'             => ['nullable', 'array'],
            'prices.*.option_id' => ['required', 'integer', 'exists:product_price_options,id'],
            'prices.*.price'     => ['required', 'integer', 'min:1'],
            'city_id'            => ['required', 'integer', 'exists:cities,id'],
            'person_count_id'    => ['nullable', 'integer', 'exists:person_counts,id'],
            'age_restriction_id' => ['nullable', 'integer', 'exists:age_restrictions,id'],
            'weather'            => ['nullable', 'string', 'max:255'],
            'special_clothing'   => ['nullable', 'string', 'max:1000'],
            'other_info'         => ['nullable', 'string'],
            'img'                => ['required', 'string', 'max:500'],
            'gallery'            => ['nullable', 'string'],
            'video'              => ['nullable', 'string', 'max:500'],
            'categories'         => ['required', 'array', 'min:1'],
            'categories.*'       => ['integer', 'exists:product_categories,id'],
            'tags'               => ['nullable', 'array'],
            'tags.*'             => ['integer', 'exists:product_tags,id'],
            'address'            => ['required', 'string', 'max:500'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($v) {
            $priceEmpty  = empty($this->price) || (int) $this->price === 0;
            $pricesEmpty = empty($this->prices) || count($this->prices) === 0;

            if ($priceEmpty && $pricesEmpty) {
                $v->errors()->add('price', 'Укажите стоимость или хотя бы один вариант цены.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'title.required'         => 'Необходимо ввести название услуги.',
            'title.max'              => 'Название услуги макс. :max символов.',
            'price.required'         => 'Необходимо указать стоимость услуги.',
            'price.min'              => 'Стоимость должна быть больше нуля.',
            'city_id.required'       => 'Необходимо выбрать город.',
            'city_id.exists'         => 'Выбранный город не найден.',
            'person_count_id.exists' => 'Выбранное количество человек не найдено.',
            'age_restriction_id.exists' => 'Выбранное возрастное ограничение не найдено.',
            'categories.required'    => 'Необходимо выбрать хотя бы одну категорию.',
            'categories.min'         => 'Необходимо выбрать хотя бы одну категорию.',
            'weather.max'            => 'Поле «Погодные условия» не должно превышать :max символов.',
            'special_clothing.max'   => 'Поле «Специальная одежда» не должно превышать :max символов.',
            'img.required'           => 'Необходимо загрузить основное изображение.',
            'address.required'       => 'Необходимо указать адрес проведения услуги.',
            'address.max'            => 'Адрес не должен превышать :max символов.',
            'categories.*.integer'   => 'Некорректная категория.',
            'tags.*.integer'         => 'Некорректный тег.',
        ];
    }
}
