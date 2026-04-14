<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use Illuminate\Support\Facades\Storage;
use MoonShine\Laravel\Pages\Page;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Support\Enums\FormMethod;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;


class HomePage extends Page
{
    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        return [
            '#' => $this->getTitle()
        ];
    }

    public function setting(): array|null
    {

        if (Storage::disk('config')->exists('moonshine/home.php')) {
            $result = include(storage_path('app/public/config/moonshine/home.php'));
        } else {
            $result = null;
        }

        return (is_array($result)) ? $result : null;

    }

    public function getTitle(): string
    {
        return $this->title ?: 'Home';
    }

    /**
     * @return list<ComponentContract>
     */
    protected function components(): iterable
    {
        if (!is_null($this->setting())) {
            extract($this->setting());
        }

        return [
            FormBuilder::make('/moonshine/home', FormMethod::POST)
                ->fields([

                    Tabs::make([

                        Tab::make(__('Главная'), [


                            Grid::make([


                                Column::make([

                                    Divider::make('Слайдер'),
                                    Text::make('Заголовок', 'title')->unescape()->default((isset($title)) ? $title : ''),
                                    Text::make('Подзаголовок', 'sub_title')->unescape()->default((isset($sub_title)) ? $sub_title : '')->hint('Картинка слайдера лежит в папке images/slider/kr-slider.jpg'),

                                    Divider::make('Категории'),
                                    Text::make('Заголовок', 'cat_title')->unescape()->default((isset($cat_title)) ? $cat_title : ''),
                                    Text::make('Заголовок', 'category_title')->unescape()->default((isset($category_title)) ? $category_title : ''),
                                    Text::make('Подзаголовок', 'category_subtitle')->unescape()->default((isset($category_subtitlee)) ? $category_subtitlee : ''),

                                    Divider::make('Описание'),
                                    TinyMce::make('HTML', 'desc')->unescape()->default((isset($desc)) ? $desc : ''),


                                ])->columnSpan(8),


                                Column::make([
                                    Divider::make('Metatitle'),

                                    Box::make([
                                        Text::make('Title ', 'metatitle')->unescape()->default((isset($metatitle)) ? $metatitle : ''),
                                        Text::make('Description', 'description')->unescape()->default((isset($description)) ? $description : ''),
                                        Text::make('Keywords', 'keywords')->unescape()->default((isset($keywords)) ? $keywords : ''),
                                    ]),

                                ])->columnSpan(4),
                            ]),


                        ]),


                    ]),


                ])->submit(label: 'Сохранить', attributes: ['class' => 'btn-primary'])
        ];
    }
}
