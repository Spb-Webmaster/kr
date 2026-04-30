<?php

namespace App\Http\Requests\CabinetVendor;

use Illuminate\Foundation\Http\FormRequest;

class VendorGalleryImageUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image' => ['required', 'file', 'image', 'max:5120', 'mimes:jpg,jpeg,png,webp,gif'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'Файл не выбран.',
            'image.file'     => 'Загружаемый объект должен быть файлом.',
            'image.image'    => 'Файл должен быть изображением.',
            'image.max'      => 'Размер файла не должен превышать 5Mb.',
            'image.mimes'    => 'Допустимые форматы: JPG, PNG, WebP, GIF.',
        ];
    }
}
