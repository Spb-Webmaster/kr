<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\IndividualEntrepreneur\Pages;

use App\Enum\Moonshine\PaymentNdsEnum;
use App\MoonShine\Resources\Taxation\TaxationResource;
use App\MoonShine\Resources\Vendor\VendorResource;
use Illuminate\Validation\Rule;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FormBuilderContract;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use App\MoonShine\Resources\IndividualEntrepreneur\IndividualEntrepreneurResource;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Enum;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;
use Throwable;


/**
 * @extends FormPage<IndividualEntrepreneurResource>
 */
class IndividualEntrepreneurFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [

            Box::make([
                ID::make(),
                Divider::make('Индивидуальный предприниматель'),

                        Grid::make([
                            Column::make([

                                Box::make([
                                    Text::make('Краткое наименование', 'name')->unescape()->required()->locked(),
                                    Text::make('Полное наименование ', 'full_name')->unescape()->locked(),
                                    Text::make('Адрес регистрации', 'register_address')->unescape()->locked(),
                                    Text::make('Фактический адрес', 'address')->unescape()->locked(),
                                    Text::make(__('Email'), 'email')->unescape()->locked(),
                                    Number::make('Телефон', 'phone')->min(1000)->max(1000000000000)->nullable()->hint('ТОЛЬКО цифры')->locked(),
                                    Text::make(__('ИНН'), 'inn')->unescape()->locked(),
                                    Text::make(__('ОГРНИП'), 'ogrnip')->unescape()->locked(),
                                    Text::make(__('Наименование банка'), 'bank')->unescape()->locked(),
                                    Text::make(__('БИК'), 'bik')->unescape()->locked(),
                                    Text::make(__('Корреспондентский счет'), 'correspondent_account')->unescape()->locked(),
                                    Text::make(__('Расчетный счет'), 'payment_account')->unescape()->locked(),
                                    Text::make(__('ОКВЭД'), 'okved')->unescape()->locked(),

                                ]),


                            ])->columnSpan(6),
                            Column::make([
                                Divider::make('Служебные'),

                                Box::make([

                                    BelongsTo::make('Продавец', 'vendor', 'surname', resource: VendorResource::class)->unescape()->nullable()->creatable(),

                                    BelongsTo::make('Система налогообложения', 'taxation', 'title', resource: TaxationResource::class)->unescape()->nullable()->creatable(),

                                    Enum::make('Уплата НДС', 'payment_nds')
                                        ->attach(PaymentNdsEnum::class),

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
                Rule::unique('individual_entrepreneurs')->ignore($item->email, 'email'),
            ],
            'phone' => [
                Rule::unique('individual_entrepreneurs')->ignore($item->phone, 'phone'),
            ],
            'vendor_id' => ['unique:individual_entrepreneurs', 'nullable: true']

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
