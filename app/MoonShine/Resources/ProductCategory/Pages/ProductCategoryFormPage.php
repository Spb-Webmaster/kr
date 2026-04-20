<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\ProductCategory\Pages;

use App\Enum\Moonshine\PaymentNdsEnum;
use App\MoonShine\Resources\Taxation\TaxationResource;
use App\MoonShine\Resources\Vendor\VendorResource;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FormBuilderContract;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use App\MoonShine\Resources\ProductCategory\ProductCategoryResource;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Enum;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use Throwable;


/**
 * @extends FormPage<ProductCategoryResource>
 */
class ProductCategoryFormPage extends FormPage
{
    protected function fields(): iterable
    {
        return [

            Box::make([
                ID::make(),
                Divider::make('Категории сертификатов'),

                Grid::make([
                    Column::make([

                        Box::make([
                            Text::make('Название', 'title')->unescape()->required(),
                            Slug::make('Slug', 'slug')
                                ->from('title')->unique()->locked(),
                            Text::make('Подзаголовок', 'subtitle')->unescape()
                        ]),
                        Box::make([
                            Image::make(__('Img'), 'img')
                                ->dir('product_category')
                                ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg', 'gif'])
                                ->removable(),
                            //   TinyMce::make('Short Description', 'short_desc'),

                        ]),

                    ])->columnSpan(6),
                    Column::make([

                        Divider::make('Метатеги '),

                        Box::make([
                            Text::make('Title ', 'metatitle')->unescape(),
                            Text::make('Description', 'description'),
                            Text::make('Keywords', 'keywords')->unescape(),
                        ]),


                        Divider::make('Служебные'),

                        Box::make([

           /*                 BelongsTo::make('Продавец', 'vendor', 'surname', resource: VendorResource::class)->unescape()->nullable()->creatable(),

                            BelongsTo::make('Система налогообложения', 'taxation', 'title', resource: TaxationResource::class)->unescape()->nullable()->creatable(),

                            Enum::make('Уплата НДС', 'payment_nds')
                                ->attach(PaymentNdsEnum::class),*/
                            Switcher::make('Публикация', 'published'),

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
        return [];
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
