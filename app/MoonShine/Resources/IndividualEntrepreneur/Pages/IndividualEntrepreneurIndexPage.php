<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\IndividualEntrepreneur\Pages;

use App\MoonShine\Resources\Vendor\VendorResource;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\QueryTags\QueryTag;
use MoonShine\UI\Components\Metrics\Wrapped\Metric;
use MoonShine\UI\Fields\ID;
use App\MoonShine\Resources\IndividualEntrepreneur\IndividualEntrepreneurResource;
use MoonShine\Support\ListOf;
use MoonShine\UI\Fields\Text;
use Throwable;


/**
 * @extends IndexPage<IndividualEntrepreneurResource>
 */
class IndividualEntrepreneurIndexPage extends IndexPage
{
    protected bool $isLazy = true;

    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            Text::make('Индивидуальный предприниматель', 'name'),
            Text::make('Email', 'email'),
            Text::make('ИНН', 'inn'),
            Text::make('Банк', 'bank'),
            BelongsTo::make('Продавец', 'vendor', 'surname', resource: VendorResource::class)->nullable(),
        ];
    }

    /**
     * @return ListOf
     */
    protected function buttons(): ListOf
    {
        return parent::buttons();
    }

    /**
     * @return list<FieldContract>
     */
    protected function filters(): iterable
    {
        return [
            Text::make('ИП', 'name'),
            Text::make('ИНН', 'inn'),
            BelongsTo::make('Продавец  - Имя', 'vendor', 'username', resource: VendorResource::class)->nullable(),
            BelongsTo::make('Продавец  - Фамилия', 'vendor', 'surname', resource: VendorResource::class)->nullable(),        ];
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

    /**
     * @param  TableBuilder  $component
     *
     * @return TableBuilder
     */
    protected function modifyListComponent(ComponentContract $component): ComponentContract
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
