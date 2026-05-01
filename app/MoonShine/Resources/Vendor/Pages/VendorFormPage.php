<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Vendor\Pages;

use App\Models\IndividualEntrepreneur;
use App\Models\LegalEntity;
use App\Models\SelfEmployed;
use App\MoonShine\Fields\Belong;
use App\MoonShine\Resources\City\CityResource;
use App\MoonShine\Resources\IndividualEntrepreneur\IndividualEntrepreneurResource;
use App\MoonShine\Resources\LegalEntity\LegalEntityResource;
use App\MoonShine\Resources\SelfEmployed\SelfEmployedResource;
use Illuminate\Validation\Rule;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Relationships\HasOne;
use MoonShine\Laravel\Fields\Relationships\MorphTo;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FormBuilderContract;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use App\MoonShine\Resources\Vendor\VendorResource;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use Throwable;


/**
 * @extends FormPage<VendorResource>
 */
class VendorFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [

            Box::make([
                ID::make(),
                Divider::make('Продавцы услуг'),

                        Grid::make([
                            Column::make([

                                Box::make([
                                    Text::make('Имя', 'username')->unescape()->required()->locked(),
                                    Text::make('Фамилия', 'surname')->unescape()->locked(),
                                    Text::make('Отчество', 'patronymic')->unescape()->locked(),
                                    TinyMce::make('Описание деятельности', 'about_me'),
                                    Text::make(__('Email'), 'email')->unescape()->locked()->required(),
                                    Number::make('Телефон', 'phone')->min(1000)->max(1000000000000)->nullable()->hint('ТОЛЬКО цифры')->locked(),
                                    Divider::make('Введите пароль'),
                                    Text::make('Пароль', 'password')->unescape()->required()->locked(),
                                ]),

                            ])->columnSpan(6),
                            Column::make([
                                Divider::make('Служебные'),

                                Box::make([

                                    Switcher::make('Публикация', 'published')->default(1),

                                    BelongsTo::make('Город', 'city', 'title', resource: CityResource::class)->unescape()->nullable(),

                                    Divider::make('Принадлежность'),
                                    Belong::make(),

                                    Date::make(__('Дата создания'), 'created_at')
                                        ->format("d.m.Y")
                                        ->default(now()->toDateTimeString())
                                        ->sortable(),

                                    Divider::make('Файлы'),
                                    File::make('Файл 1', 'file1')->nullable()->disk('public')->dir('vendor_files')->allowedExtensions(['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'rtf', 'odt', 'ods', 'csv', 'jpg', 'jpeg', 'png', 'gif', 'webp', 'zip', 'rar'])->removable()->customName(fn($file) => $this->uniqueFileName('vendor_files', $file->getClientOriginalName())),
                                    File::make('Файл 2', 'file2')->nullable()->disk('public')->dir('vendor_files')->allowedExtensions(['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'rtf', 'odt', 'ods', 'csv', 'jpg', 'jpeg', 'png', 'gif', 'webp', 'zip', 'rar'])->removable()->customName(fn($file) => $this->uniqueFileName('vendor_files', $file->getClientOriginalName())),
                                    File::make('Файл 3', 'file3')->nullable()->disk('public')->dir('vendor_files')->allowedExtensions(['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'rtf', 'odt', 'ods', 'csv', 'jpg', 'jpeg', 'png', 'gif', 'webp', 'zip', 'rar'])->removable()->customName(fn($file) => $this->uniqueFileName('vendor_files', $file->getClientOriginalName())),
                                ]),

                            ])->columnSpan(6),

           /*                 HasOne::make(
                                'Юридическое лицо',
                                'legalEntity',
                                resource: LegalEntityResource::class
                            ),

                            HasOne::make(
                                'Индивидуальный предприниматель',
                                'individualEntrepreneur',
                                resource: IndividualEntrepreneurResource::class
                            ),

                            HasOne::make(
                                'Самозанятый',
                                'selfEmployed',
                                resource: SelfEmployedResource::class
                            ),*/


                        ]),
                    ]),


        ];

    }

    private function uniqueFileName(string $dir, string $originalName): string
    {
        $name      = pathinfo($originalName, PATHINFO_FILENAME);
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $filename  = $originalName;
        $counter   = 1;

        while (\Illuminate\Support\Facades\Storage::disk('public')->exists($dir . '/' . $filename)) {
            $filename = $name . '_' . $counter . '.' . $extension;
            $counter++;
        }

        return $filename;
    }

    protected function buttons(): ListOf
    {
        return parent::buttons();
    }

    protected function formButtons(): ListOf
    {
        return parent::formButtons();
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [
            'email' => [
                'sometimes',
                'bail',
                'required',
                'email',
                Rule::unique('vendors')->ignore($item->email, 'email'),
            ],
            'phone' => [
                Rule::unique('vendors')->ignore($item->phone, 'phone'),
                ]
        ];

    }

    /**
     * @param FormBuilder $component
     *
     * @return FormBuilder
     */
    protected function modifyFormComponent(FormBuilderContract $component): FormBuilderContract
    {
        return $component;
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function topLayer(): array
    {
        return [
            ...parent::topLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer()
        ];
    }
}
