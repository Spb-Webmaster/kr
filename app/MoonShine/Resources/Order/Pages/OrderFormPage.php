<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Order\Pages;

use App\Enum\CertificateStatus;
use App\MoonShine\Fields\RelationDisplay;
use App\MoonShine\Resources\Order\OrderResource;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Enum;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Text;
use Throwable;

/**
 * @extends FormPage<OrderResource>
 */
class OrderFormPage extends FormPage
{
    protected function fields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Divider::make('Заказ'),

                Grid::make([
                    Column::make([

                        Box::make('Данные покупателя', [
                            Text::make('Номер заказа', 'number')->locked(),
                            Text::make('Покупатель', 'username'),
                            Text::make('Email', 'email'),
                            Text::make('Телефон', 'phone'),
                        ]),

                        Box::make('Услуга', [
                            Text::make('Название услуги', 'title'),
                            Text::make('Вариант цены', 'price_option'),
                            Text::make('Сумма заказа', 'price'),
                        ]),

                        Box::make('Оплата (ЮКасса)', [
                            Text::make('ID платежа', 'id_yoo_kassa'),
                            Text::make('Статус платежа', 'status_yoo_kassa'),
                            Json::make('Уведомления ЮКасса', 'notification_yoo_kassa')
                                ->readonly(),
                        ]),

                    ])->columnSpan(8),

                    Column::make([

                        Box::make('Статус', [
                            Enum::make('Статус сертификата', 'certificate_status')->attach(CertificateStatus::class),
                            Date::make('Дата создания', 'created_at')
                                ->format('d.m.Y H:i')
                                ->readonly(),
                        ]),

                        Box::make('Связи', [
                            RelationDisplay::make('Покупатель', 'user')
                                ->display(fn($user) => "$user->username | $user->email"),
                            RelationDisplay::make('Продавец', 'vendor')
                                ->display(fn($vendor) => "$vendor->surname $vendor->username | $vendor->email"),
                            RelationDisplay::make('Услуга', 'product')
                                ->display(fn($product) => $product->title),
                        ]),

                    ])->columnSpan(4),
                ]),
            ]),
        ];
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [];
    }
}
