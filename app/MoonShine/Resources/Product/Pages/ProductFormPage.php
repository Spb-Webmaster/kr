<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Product\Pages;

use App\Models\ProductPriceOption;
use App\MoonShine\Fields\OrderPaperCreate;
use App\MoonShine\Resources\AgeRestriction\AgeRestrictionResource;
use App\MoonShine\Resources\PersonCount\PersonCountResource;
use App\MoonShine\Resources\ProductCategory\ProductCategoryResource;
use App\MoonShine\Resources\ProductTag\ProductTagResource;
use App\MoonShine\Resources\City\CityResource;
use App\MoonShine\Resources\Vendor\VendorResource;
use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Field;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\ID;
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

                Tabs::make([

                    Tab::make('Сертификат', [
                        Text::make('Название', 'title')->unescape()->required(),
                        Slug::make('Slug', 'slug')->from('title')->unique()->locked(),
                        Text::make('Подзаголовок', 'subtitle')->unescape(),
                    ]),

                    Tab::make('Изображение', [
                        Image::make('Главная картинка', 'img')
                            ->dir('images')
                            ->customName(fn(UploadedFile $file, $field) => $this->buildUploadPath($file, $field))
                            ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg', 'webp'])
                            ->removable()
                            ->onAfterApply(function (Model $item, mixed $file, Image $field) {
                                if ($file === false || !$item->vendor_id || !$item->id || !$item->img) {
                                    return $field;
                                }
                                $expected = "images/vendors/{$item->vendor_id}/{$item->id}/" . basename($item->img);
                                if ($item->img !== $expected) {
                                    Storage::disk('public')->move($item->img, $expected);
                                    $item->img = $expected;
                                    $item->saveQuietly();
                                }
                                return $field;
                            }),

                        Json::make('Галерея', 'gallery')->fields([
                            Text::make('', 'json_gallery_label')->hint('title image'),
                            Image::make('', 'json_gallery_text')
                                ->dir('images')
                                ->customName(fn(UploadedFile $file, $field) => $this->buildUploadPath($file, $field))
                                ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg', 'webp'])
                                ->removable(),
                        ])->vertical()->creatable(limit: 100)->removable()
                            ->onAfterApply(function (Model $item, mixed $value, Json $field) {
                                if (!$item->vendor_id || !$item->id || !$item->gallery?->count()) {
                                    return $field;
                                }
                                $needsUpdate = false;
                                $gallery = $item->gallery->map(function ($row) use ($item, &$needsUpdate) {
                                    $img = data_get($row, 'json_gallery_text');
                                    if (!$img) return $row;
                                    $expected = "images/vendors/{$item->vendor_id}/{$item->id}/" . basename($img);
                                    if ($img !== $expected && Storage::disk('public')->exists($img)) {
                                        Storage::disk('public')->move($img, $expected);
                                        $needsUpdate = true;
                                        return array_merge((array) $row, ['json_gallery_text' => $expected]);
                                    }
                                    return $row;
                                });
                                if ($needsUpdate) {
                                    $item->gallery = $gallery;
                                    $item->saveQuietly();
                                }
                                return $field;
                            }),
                    ]),

                    Tab::make('Описание', [
                        TinyMce::make('Описание услуги', 'desc'),
                        TinyMce::make('Погодные условия', 'weather'),
                        TinyMce::make('Спец. одежда', 'special_clothing'),
                        TinyMce::make('Дополнительная информация', 'other_info'),
                    ]),

                    Tab::make('Цена', [
                        Number::make('Обычная цена', 'price')->hint('Без обычной цены поставить "0"'),
                        Json::make('Цены', 'prices')->fields([
                            Select::make('Опция', 'option_id')
                                ->options(
                                    ProductPriceOption::query()->pluck('title', 'id')->toArray()
                                )->required(),
                            Number::make('Цена', 'price')->required(),
                        ])->creatable()->removable()->vertical(),
                    ]),

                    Tab::make('Опции', [
                        BelongsTo::make('Продавец', 'vendor', 'surname', resource: VendorResource::class)->unescape(),
                        BelongsTo::make('Город', 'city', 'title', resource: CityResource::class)->unescape()->nullable(),
                        Text::make('Адрес', 'address')->nullable(),
                        BelongsToMany::make('Категории', 'categories', 'title', resource: ProductCategoryResource::class)
                            ->valuesQuery(fn(Builder $query, Field $field) => $query->orderBy('sorting', 'DESC'))
                            ->nullable()->creatable(),
                        BelongsToMany::make('Теги', 'tags', 'title', resource: ProductTagResource::class)
                            ->valuesQuery(fn(Builder $query, Field $field) => $query->orderBy('sorting', 'DESC'))
                            ->nullable()->creatable(),
                        BelongsTo::make('Количество человек', 'personCount', 'title', resource: PersonCountResource::class)->unescape()->nullable()->creatable(),
                        BelongsTo::make('Возрастное ограничение', 'ageRestriction', 'title', resource: AgeRestrictionResource::class)->unescape()->nullable()->creatable(),
                        Date::make('Дата создания', 'created_at')
                            ->format('d.m.Y')
                            ->default(now()->toDateTimeString())
                            ->sortable(),
                    ]),

                    Tab::make('Метатеги', [
                        Text::make('Title', 'metatitle')->unescape(),
                        Text::make('Description', 'description'),
                        Text::make('Keywords', 'keywords')->unescape(),
                    ]),

                    Tab::make('Видео', [
                        File::make('Видео', 'video')
                            ->dir('video')
                            ->customName(fn(UploadedFile $file, $field) => $this->buildUploadPath($file, $field))
                            ->allowedExtensions(['mp4', 'webm', 'ogg', 'mov', 'avi', 'm4v', 'mkv', 'flv', 'wmv', 'mpg', 'mpeg', 'm2v', '3gp', '3g2', 'ts', 'mts', 'm2ts', 'vob', 'divx', 'xvid', 'rm', 'rmvb', 'asf', 'swf', 'ogv'])
                            ->removable()
                            ->onAfterApply(function (Model $item, mixed $file, File $field) {
                                if ($file === false || !$item->vendor_id || !$item->id || !$item->video) {
                                    return $field;
                                }
                                $expected = "video/vendors/{$item->vendor_id}/{$item->id}/" . basename($item->video);
                                if ($item->video !== $expected) {
                                    Storage::disk('public')->move($item->video, $expected);
                                    $item->video = $expected;
                                    $item->saveQuietly();
                                }
                                return $field;
                            }),
                    ]),

                    Tab::make('Бумажные сертификаты', [
                        OrderPaperCreate::make('', 'order_paper_create'),
                    ]),

                ]),
            ]),
        ];
    }

    private function buildUploadPath(UploadedFile $file, mixed $field): string
    {
        $productId = moonshineRequest()->getItemID();
        $vendorId  = $field->getData()?->getOriginal()?->vendor_id
            ?? request()->integer('vendor_id') ?: null;

        if (!$vendorId && $productId) {
            $vendorId = Product::find($productId)?->vendor_id;
        }

        $parts = array_values(array_filter(['vendors', $vendorId, $productId]));

        return ($parts ? implode('/', $parts) . '/' : '') . Str::random(20) . '.' . $file->extension();
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
        return [...parent::topLayer()];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function mainLayer(): array
    {
        return [...parent::mainLayer()];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function bottomLayer(): array
    {
        return [...parent::bottomLayer()];
    }
}
