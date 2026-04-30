<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\OrderPaper;

use App\Models\OrderPaper;
use App\MoonShine\Resources\OrderPaper\Pages\OrderPaperFormPage;
use App\MoonShine\Resources\OrderPaper\Pages\OrderPaperIndexPage;
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
 * @extends ModelResource<OrderPaper, OrderPaperIndexPage, OrderPaperFormPage>
 */
class OrderPaperResource extends ModelResource implements HasImportExportContract
{
    use ImportExportConcern;

    protected string $model = OrderPaper::class;
    protected array $with = ['product', 'vendor'];

    protected string $title = 'Бумажные заказы';
    protected string $column = 'number';
    protected string $sortColumn = 'created_at';
    protected SortDirection $sortDirection = SortDirection::DESC;

    protected function activeActions(): ListOf
    {
        return parent::activeActions()->except(Action::CREATE);
    }

    public function search(): array
    {
        return ['number'];
    }

    protected function exportFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Номер', 'number'),
            Text::make('Услуга', 'product.title'),
            Text::make('Продавец', 'vendor_id')
                ->modifyRawValue(fn($value, $orderPaper) => ($v = $orderPaper->vendor)
                    ? "{$v->surname} {$v->username} / " . format_phone($v->phone) . " / {$v->email}"
                    : '—'
                ),
            Text::make('Вариант цены', 'price_option'),
            Text::make('Сумма', 'price'),
            Date::make('Дата', 'created_at')->format('d.m.Y H:i'),
        ];
    }

    protected function export(): ?Handler
    {
        return ExportHandler::make('Экспорт в Excel')
            ->filename(sprintf('order_papers_%s', date('Ymd_His')));
    }

    protected function import(): ?Handler
    {
        return null;
    }

    protected function pages(): array
    {
        return [
            OrderPaperIndexPage::class,
            OrderPaperFormPage::class,
        ];
    }
}
