<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\OrderPaper\Pages;

use App\Models\OrderPaper;
use App\Models\Product;
use App\Models\Vendor;
use App\MoonShine\Resources\OrderPaper\OrderPaperResource;
use Illuminate\Contracts\Database\Eloquent\Builder;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Laravel\QueryTags\QueryTag;
use MoonShine\UI\Components\Metrics\Wrapped\Metric;
use App\Enum\CertificateStatus;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\DateRange;
use MoonShine\UI\Fields\Enum;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Preview;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;

/**
 * @extends IndexPage<OrderPaperResource>
 */
class OrderPaperIndexPage extends IndexPage
{
    protected bool $isLazy = true;

    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            Text::make('Номер', 'number'),
            Image::make('Изображение', 'product.img'),
            Text::make('Услуга', 'product.title'),
            Preview::make('Продавец', 'vendor_id')
                ->changePreview(function ($value, $field) {
                    $vendor = $field->getData()?->getOriginal()->vendor;
                    if (!$vendor) return '—';
                    return "{$vendor->surname} {$vendor->username}<br>" . format_phone($vendor->phone) . "<br>{$vendor->email}";
                }),
            Text::make('Вариант цены', 'price_option'),
            Text::make('Сумма', 'price'),
            Enum::make('Сертификат', 'certificate_status')->attach(CertificateStatus::class),
            Date::make('Дата', 'created_at')->format('d.m.Y H:i')->sortable(),
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function filters(): iterable
    {
        return [
            Text::make('Номер', 'number'),

            Select::make('Услуга', 'product_id')
                ->options(
                    Product::query()
                        ->whereIn('id', OrderPaper::distinct()->pluck('product_id'))
                        ->pluck('title', 'id')
                        ->toArray()
                )
                ->nullable()
                ->searchable(),

            Select::make('Продавец', 'vendor_id')
                ->options(
                    Vendor::query()
                        ->whereIn('id', OrderPaper::distinct()->pluck('vendor_id'))
                        ->get()
                        ->mapWithKeys(fn($v) => [$v->id => "{$v->surname} {$v->username}"])
                        ->toArray()
                )
                ->nullable()
                ->searchable()
                ->onApply(fn(Builder $query, $value) => $query->where('vendor_id', $value)),

            Select::make('Вариант цены', 'price_option')
                ->options(
                    OrderPaper::query()
                        ->whereNotNull('price_option')
                        ->distinct()
                        ->pluck('price_option')
                        ->mapWithKeys(fn($v) => [$v => $v])
                        ->toArray()
                )
                ->nullable()
                ->onApply(fn(Builder $query, $value) => $query->where('price_option', $value)),

            Number::make('Сумма от', 'price_from')
                ->onApply(fn(Builder $query, $value) => $value !== null && $value !== ''
                    ? $query->where('price', '>=', (int) $value)
                    : $query
                ),

            Number::make('Сумма до', 'price_to')
                ->onApply(fn(Builder $query, $value) => $value !== null && $value !== ''
                    ? $query->where('price', '<=', (int) $value)
                    : $query
                ),

            DateRange::make('Период', 'created_at')
                ->fromTo('date_from', 'date_to')
                ->onApply(function (Builder $query, mixed $value) {
                    if (!empty($value['from'])) {
                        $query->whereDate('created_at', '>=', $value['from']);
                    }
                    if (!empty($value['to'])) {
                        $query->whereDate('created_at', '<=', $value['to']);
                    }
                    return $query;
                }),

            Select::make('Статус сертификата', 'certificate_status')
                ->options(
                    collect(CertificateStatus::cases())
                        ->mapWithKeys(fn($case) => [$case->value => $case->toString()])
                        ->toArray()
                )
                ->nullable(),
        ];
    }

    /**
     * @return list<QueryTag>
     */
    protected function queryTags(): array
    {
        return [];
    }

    /**
     * @return list<Metric>
     */
    protected function metrics(): array
    {
        return [];
    }
}
