<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Product;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\MoonShine\Resources\Product\Pages\ProductIndexPage;
use App\MoonShine\Resources\Product\Pages\ProductFormPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Support\Enums\SortDirection;

/**
 * @extends ModelResource<Product, ProductIndexPage, ProductFormPage>
 */
class ProductResource extends ModelResource
{
    protected string $model = Product::class;

    protected string $title = 'Сертификаты';
    protected string $column = 'title';
    protected string $sortColumn = 'created_at';
    protected SortDirection $sortDirection = SortDirection::ASC;
    public function search(): array
    {
        return ['title', 'subtitle'];
    }
    protected function pages(): array
    {
        return [
            ProductIndexPage::class,
            ProductFormPage::class,
        ];
    }
}
