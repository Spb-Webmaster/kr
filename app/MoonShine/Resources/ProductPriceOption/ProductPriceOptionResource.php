<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\ProductPriceOption;

use App\Models\ProductPriceOption;
use App\MoonShine\Resources\ProductPriceOption\Pages\ProductPriceOptionIndexPage;
use App\MoonShine\Resources\ProductPriceOption\Pages\ProductPriceOptionFormPage;

use MoonShine\Laravel\Resources\ModelResource;

/**
 * @extends ModelResource<ProductPriceOption, ProductPriceOptionIndexPage, ProductPriceOptionFormPage>
 */
class ProductPriceOptionResource extends ModelResource
{
    protected string $model = ProductPriceOption::class;
    protected string $title = 'Опции цен';
    protected string $column = 'title';
    protected string $sortColumn = 'sorting';

    public function search(): array
    {
        return ['title'];
    }

    protected function pages(): array
    {
        return [
            ProductPriceOptionIndexPage::class,
            ProductPriceOptionFormPage::class,
        ];
    }
}
