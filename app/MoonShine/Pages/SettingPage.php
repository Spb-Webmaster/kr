<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use Illuminate\Support\Facades\Storage;
use MoonShine\Laravel\Pages\Page;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Support\Enums\FormMethod;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;


class SettingPage extends Page
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

    public function setting()
    {

        if (Storage::disk('config')->exists('moonshine/setting.php')) {
            $result = include(storage_path('app/public/config/moonshine/setting.php'));
        } else {
            $result = null;
        }

        return (is_array($result)) ? $result : null;

    }

    public function getTitle(): string
    {
        return $this->title ?: 'Настройки сайта';
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
            FormBuilder::make('/moonshine/setting', FormMethod::POST)
                ->fields([

                    Tabs::make([

                        Tab::make(__('Настройки'), [

                            Grid::make([

                                Column::make([


                                    Divider::make('Преимущества'),

                                    Box::make([
                                        Text::make('Преимущество 1', 'adv1')->default((isset($adv1)) ? $adv1 : '')->unescape(),
                                        Text::make('Преимущество 2', 'adv2')->default((isset($adv2)) ? $adv2 : '')->unescape(),
                                        Text::make('Преимущество 3', 'adv3')->default((isset($adv3)) ? $adv3 : '')->unescape(),

                                    ]),

                                    Divider::make('Соц.сети'),

                                    Box::make([
                                        Text::make('Telegram', 'telegram')->default((isset($telegram)) ? $telegram : '')->unescape(),
                                        Text::make('Max', 'Max')->unescape()->default((isset($Max)) ? $Max : ''),
                                        Text::make('Vk.com', 'vk')->unescape()->default((isset($vk)) ? $vk : ''),
                                    ]),

                                ])->columnSpan(6),


                                Column::make([
                                    Divider::make('Контакты'),

                                    Box::make([
                                        Number::make('Телефон', 'phone')->default((isset($phone)) ? $phone : '')->hint('Вводите только цифры! Пример: 79180000000'),
                                        Text::make('Email', 'email')->default((isset($email)) ? $email : '')->unescape(),
                                        Textarea::make('Адрес', 'address_top')->default((isset($address_top)) ? $address_top : '')->unescape(),

                                    ]),



                                ])->columnSpan(6),
                            ]),
                        ]),

                        Tab::make(__('Футер'), [

                            Divider::make('Константы'),

                            Box::make([
                                Text::make('Адрес первая строчка', 'address_footer_top')->default((isset($address_footer_top)) ? $address_footer_top : '')->unescape(),
                                Text::make('Адрес вторая строчка', 'address_footer_bottom')->default((isset($address_footer_bottom)) ? $address_footer_bottom : '')->unescape(),

                            ]),

                            Box::make([
                                Textarea::make('Скрипт1', 'footer_script1')->default((isset($footer_script1)) ? $footer_script1 : '')->unescape(),
                                Textarea::make('Скрипт2', 'footer_script2')->default((isset($footer_script2)) ? $footer_script2 : '')->unescape(),
                                Textarea::make('Скрипт3', 'footer_script3')->default((isset($footer_script3)) ? $footer_script3 : '')->unescape(),

                            ]),

                        ]),
                        Tab::make(__('Банер'), [

                            Divider::make('С правой стороны'),

                            Box::make([
                                Text::make('Банер1 ', 'red_banner')->default((isset($red_banner)) ? $red_banner : '')->unescape()->hint('Банер является обязательным и можно писать только текст в html'),
                                Textarea::make('Банер2', 'marketing')->default((isset($marketing)) ? $marketing : '')->unescape(),

                            ]),

                            Box::make([
                                Textarea::make('Скрипт1', 'footer_script1')->default((isset($footer_script1)) ? $footer_script1 : '')->unescape(),
                                Textarea::make('Скрипт2', 'footer_script2')->default((isset($footer_script2)) ? $footer_script2 : '')->unescape(),
                                Textarea::make('Скрипт3', 'footer_script3')->default((isset($footer_script3)) ? $footer_script3 : '')->unescape(),

                            ]),

                        ]),

                        Tab::make(__('Email получателя системных сообщений'), [

                            Divider::make('Опции'),
                            Grid::make([
                                Column::make([

                                    Box::make([
                                        Json::make('Электронная почта', 'json_emails')->fields([

                                            Text::make('', 'json_email')->hint('Владелец этого email будет получать все уведомления (изменения) при редактировании личных кабинетов пользователями.'),

                                        ])->vertical()->creatable(limit: 3)
                                            ->removable()->default((isset($json_emails)) ? $json_emails : ''),


                                    ]),

                                ])->columnSpan(12),


                            ])


                        ]),


                    ]),


                ])->submit(label: 'Сохранить', attributes: ['class' => 'btn-primary'])
        ];
    }
}
