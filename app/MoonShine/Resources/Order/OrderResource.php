<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Order;

use App\Models\Order;
use App\MoonShine\Resources\Order\Pages\OrderFormPage;
use App\MoonShine\Resources\Order\Pages\OrderIndexPage;
use MoonShine\Crud\Handlers\Handler;
use MoonShine\ImportExport\Contracts\HasImportExportContract;
use MoonShine\ImportExport\ExportHandler;
use MoonShine\ImportExport\Traits\ImportExportConcern;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\Support\ListOf;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Order, OrderIndexPage, OrderFormPage>
 */
class OrderResource extends ModelResource implements HasImportExportContract
{
    use ImportExportConcern;

    protected string $model = Order::class;
    protected array $with = ['product', 'vendor'];

    protected string $title = 'Заказы';
    protected string $column = 'number';
    protected string $sortColumn = 'created_at';
    protected SortDirection $sortDirection = SortDirection::DESC;

    protected function activeActions(): ListOf
    {
        return parent::activeActions()->except(Action::CREATE);
    }

    public function search(): array
    {
        return ['number', 'username', 'email', 'phone'];
    }

    protected function exportFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Номер заказа', 'number'),
            Text::make('Услуга', 'product.title'),
            Text::make('Продавец', 'vendor_id')
                ->modifyRawValue(function ($value, $order) {
                    $v = $order->vendor;
                    if (!$v) return '—';
                    $parts = array_filter([
                        "{$v->surname} {$v->username}",
                        $v->phone ? format_phone($v->phone) : null,
                        $v->email ?: null,
                    ]);
                    return implode(' / ', $parts);
                }),
            Text::make('Покупатель', 'username'),
            Text::make('Email', 'email'),
            Text::make('Телефон', 'phone'),
            Text::make('Вариант цены', 'price_option'),
            Text::make('Сумма', 'price'),
            Text::make('Статус', 'status'),
            Text::make('Оплата (ЮКасса)', 'status_yoo_kassa'),
            Date::make('Дата', 'created_at')->format('d.m.Y H:i'),
        ];
    }

    protected function export(): ?Handler
    {
        return ExportHandler::make('Экспорт в Excel')
            ->filename(sprintf('orders_%s', date('Ymd_His')));
    }

    protected function import(): ?Handler
    {
        return null;
    }

    protected function pages(): array
    {
        return [
            OrderIndexPage::class,
            OrderFormPage::class,
        ];
    }
}
