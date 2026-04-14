<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Product\Pages;

use App\Models\ProductPriceOption;
use App\MoonShine\Fields\MinPrice;
use App\MoonShine\Resources\AgeRestriction\AgeRestrictionResource;
use App\MoonShine\Resources\PersonCount\PersonCountResource;
use App\MoonShine\Resources\ProductCategory\ProductCategoryResource;
use App\MoonShine\Resources\ProductTag\ProductTagResource;
use App\MoonShine\Resources\City\CityResource;
use App\MoonShine\Resources\Vendor\VendorResource;
use Illuminate\Contracts\Database\Eloquent\Builder;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FormBuilderContract;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use App\MoonShine\Resources\Product\ProductResource;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Field;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use Throwable;


/**
 * @extends FormPage<ProductResource>
 */
class ProductFormPage extends FormPage
{
    protected function fields(): iterable
    {
        return [

            Box::make([
                ID::make(),
                Divider::make('Сертификаты'),

                Grid::make([
                    Column::make([

                        Box::make([
                            Text::make('Название', 'title')->unescape()->required(),
                            Slug::make('Slug', 'slug')
                                ->from('title')->unique()->locked(),
                            Text::make('Подзаголовок', 'subtitle')->unescape()
                        ]),
                        Box::make([
                            Image::make(__('Главная картинка'), 'img')
                                ->dir('image/product')
                                ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg', 'gif', 'webp'])
                                ->removable(),

                        ]),
                        Divider::make('Текстовые поля'),

                        Box::make([
                            TinyMce::make('Описание услуги', 'desc'),
                            TinyMce::make('Погодные условия', 'weather'),
                            TinyMce::make('Спец. одежда', 'special_clothing'),
                            TinyMce::make('Дополнительна информация', 'other_info'),
                        ]),
                        Divider::make('Галерея изображений услуги'),

                        Box::make([
                            Json::make('Галерея', 'gallery')->fields([

                                Text::make('', 'json_gallery_label')->hint('title image'),
                                Image::make(__(''), 'json_gallery_text')
                                    ->dir('image/product/gallery')
                                    ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg', 'webp'])
                                    ->removable(),
                            ])->vertical()->creatable(limit: 100)
                                ->removable(),
                        ]),


                    ])->columnSpan(8),
                    Column::make([

                        Divider::make('Метатеги '),

                        Box::make([
                            Text::make('Title ', 'metatitle')->unescape(),
                            Text::make('Description', 'description'),
                            Text::make('Keywords', 'keywords')->unescape(),
                        ]),


                        Divider::make('Цены'),
                        Box::make([

                            Number::make('Обычная цена', 'price'),

                            Json::make('Цены', 'prices')->fields([
                                Select::make('Опция', 'option_id')
                                    ->options(
                                        ProductPriceOption::query()->pluck('title', 'id')->toArray()
                                    )->required(),
                                Number::make('Цена', 'price')->required(),
                            ])->creatable()->removable()->vertical(),
                        ]),

                        Divider::make('Служебные'),

                        Box::make([
                            BelongsTo::make('Продавец', 'vendor', 'surname', resource: VendorResource::class)->unescape(),
                            BelongsTo::make('Город', 'city', 'title', resource: CityResource::class)->unescape()->nullable(),
                            BelongsToMany::make('Категории', 'categories', 'title', resource: ProductCategoryResource::class)
                                ->valuesQuery(fn(Builder $query, Field $field) => $query->orderBy('sorting', 'DESC'))
                                ->nullable()->creatable(),

                            BelongsToMany::make('Теги', 'tags', 'title', resource: ProductTagResource::class)
                                ->valuesQuery(fn(Builder $query, Field $field) => $query->orderBy('sorting', 'DESC'))
                                ->nullable()->creatable(),
                            BelongsTo::make('Возрастное ограничение', 'ageRestriction', 'title', resource: AgeRestrictionResource::class)->unescape()->nullable()->creatable(),
                            BelongsTo::make('Количество человек', 'personCount', 'title', resource: PersonCountResource::class)->unescape()->nullable()->creatable(),

                            /*                 BelongsTo::make('Продавец', 'vendor', 'surname', resource: VendorResource::class)->unescape()->nullable()->creatable(),

                                             BelongsTo::make('Система налогообложения', 'taxation', 'title', resource: TaxationResource::class)->unescape()->nullable()->creatable(),

                                             Enum::make('Уплата НДС', 'payment_nds')
                                                 ->attach(PaymentNdsEnum::class),*/

                            Date::make(__('Дата создания'), 'created_at')
                                ->format("d.m.Y")
                                ->default(now()->toDateTimeString())
                                ->sortable(),
                        ]),

                    ])->columnSpan(4),
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
