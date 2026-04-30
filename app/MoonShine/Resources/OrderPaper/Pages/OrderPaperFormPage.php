<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\OrderPaper\Pages;

use App\Enum\CertificateStatus;
use App\MoonShine\Fields\RelationDisplay;
use App\MoonShine\Resources\OrderPaper\OrderPaperResource;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Enum;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

/**
 * @extends FormPage<OrderPaperResource>
 */
class OrderPaperFormPage extends FormPage
{
    protected function fields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Divider::make('Бумажный заказ'),

                Grid::make([
                    Column::make([

                        Box::make('Заказ', [
                            Text::make('Номер', 'number')->locked(),
                            Text::make('Вариант цены', 'price_option'),
                            Text::make('Сумма', 'price'),
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
