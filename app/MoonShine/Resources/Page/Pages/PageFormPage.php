<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Page\Pages;

use App\MoonShine\Resources\Page\PageResource;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\FormBuilderContract;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Support\ListOf;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use Throwable;

/**
 * @extends FormPage<PageResource>
 */
class PageFormPage extends FormPage
{
    protected function fields(): iterable
    {
        return [

            Box::make([
                ID::make(),
                Divider::make('Страница'),

                Grid::make([
                    Column::make([

                        Box::make([
                            Text::make('Название', 'title')->unescape()->required(),
                            Slug::make('Slug', 'slug')
                                ->from('title')->unique()->locked(),
                            Text::make('Подзаголовок', 'subtitle')->unescape(),
                        ]),

                        Box::make([
                            Image::make('Изображение', 'img')
                                ->dir('image/page')
                                ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg', 'webp'])
                                ->removable(),
                        ]),

                        Divider::make('Текстовые поля'),

                        Box::make([
                            TinyMce::make('Описание', 'desc'),
                            TinyMce::make('Описание 2', 'desc2'),
                        ]),

                        Divider::make('Параметры'),

                        Box::make([
                            Json::make('Параметры', 'params')->fields([
                                Text::make('Ключ', 'key'),
                                Text::make('Значение', 'value'),
                            ])->vertical()->creatable(limit: 100)->removable(),
                        ]),

                        Divider::make('Галерея'),

                        Box::make([
                            Json::make('Галерея', 'gallery')->fields([
                                Text::make('', 'json_gallery_label')->hint('title image'),
                                Image::make('', 'json_gallery_text')
                                    ->dir('image/page/gallery')
                                    ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg', 'webp'])
                                    ->removable(),
                            ])->vertical()->creatable(limit: 100)->removable(),
                        ]),

                    ])->columnSpan(8),

                    Column::make([

                        Divider::make('Метатеги'),

                        Box::make([
                            Text::make('Title', 'metatitle')->unescape(),
                            Text::make('Description', 'description'),
                            Text::make('Keywords', 'keywords')->unescape(),
                        ]),

                        Divider::make('Служебные'),

                        Box::make([
                            Switcher::make('Публикация', 'published'),
                            Date::make('Дата создания', 'created_at')
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
