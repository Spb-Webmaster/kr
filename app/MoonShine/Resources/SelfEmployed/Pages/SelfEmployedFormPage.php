<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\SelfEmployed\Pages;

use App\MoonShine\Resources\Vendor\VendorResource;
use Illuminate\Validation\Rule;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FormBuilderContract;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use App\MoonShine\Resources\SelfEmployed\SelfEmployedResource;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;
use Throwable;


/**
 * @extends FormPage<SelfEmployedResource>
 */
class SelfEmployedFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [

            Box::make([
                ID::make(),
                Divider::make('Самозанятый'),

                        Grid::make([
                            Column::make([

                                Box::make([

                                    Text::make('Адрес регистрации', 'register_address')->unescape()->locked(),
                                    Text::make('Фактический адрес', 'address')->unescape()->locked(),
                                    Text::make(__('Email'), 'email')->unescape()->locked(),
                                    Number::make('Телефон', 'phone')->min(1000)->max(1000000000000)->nullable()->hint('ТОЛЬКО цифры')->locked(),
                                    Text::make(__('ИНН'), 'inn')->unescape()->locked(),
                                    Text::make(__('Паспорт: серия'), 'passport_serial')->unescape()->locked(),
                                    Text::make(__('Паспорт: номер'), 'passport_number')->unescape()->locked(),
                                    Text::make(__('Паспорт: кем выдал'), 'who_issued')->unescape()->locked(),
                                    Text::make(__('Паспорт: когда выдан'), 'date_issued')->unescape()->locked(),

                                    Text::make(__('Наименование банка'), 'bank')->unescape()->locked(),
                                    Text::make(__('БИК'), 'bik')->unescape()->locked(),
                                    Text::make(__('Корреспондентский счет'), 'correspondent_account')->unescape()->locked(),
                                    Text::make(__('Расчетный счет'), 'payment_account')->unescape()->locked(),

                                ]),



                            ])->columnSpan(6),
                            Column::make([
                                Divider::make('Служебные'),

                                Box::make([

                                    BelongsTo::make('Продавец', 'vendor', 'surname', resource: VendorResource::class)->unescape()->nullable()->creatable(),


                                    Date::make(__('Дата создания'), 'created_at')
                                        ->format("d.m.Y")
                                        ->default(now()->toDateTimeString())
                                        ->sortable(),
                                ]),

                            ])->columnSpan(6),
                        ]),

                    ]),


        ];
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
                Rule::unique('self_employeds')->ignore($item->email, 'email'),
            ],
            'phone' => [
                Rule::unique('self_employeds')->ignore($item->phone, 'phone'),
            ],
            'vendor_id' => ['nullable', Rule::unique('self_employeds', 'vendor_id')->ignore($item->getOriginal()->getKey())]

        ];

    }

    /**
     * @param  FormBuilder  $component
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
