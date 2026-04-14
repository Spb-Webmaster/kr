<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\ProductCategory;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductCategory;
use App\MoonShine\Resources\ProductCategory\Pages\ProductCategoryIndexPage;
use App\MoonShine\Resources\ProductCategory\Pages\ProductCategoryFormPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

/**
 * @extends ModelResource<ProductCategory, ProductCategoryIndexPage, ProductCategoryFormPage>
 */
class ProductCategoryResource extends ModelResource
{
    protected string $model = ProductCategory::class;
    protected string $title = 'Категории';
    protected string $column = 'title';
    protected string $sortColumn = 'sorting';
    public function search(): array
    {
        return ['title', 'subtitle'];
    }

    protected function pages(): array
    {
        return [
            ProductCategoryIndexPage::class,
            ProductCategoryFormPage::class,
        ];
    }
}
