<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\ProductTag;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductTag;
use App\MoonShine\Resources\ProductTag\Pages\ProductTagIndexPage;
use App\MoonShine\Resources\ProductTag\Pages\ProductTagFormPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

/**
 * @extends ModelResource<ProductTag, ProductTagIndexPage, ProductTagFormPage>
 */
class ProductTagResource extends ModelResource
{
    protected string $model = ProductTag::class;
    protected string $title = 'Теги';
    protected string $column = 'title';
    protected string $sortColumn = 'sorting';

    public function search(): array
    {
        return ['title', 'subtitle'];
    }

    protected function pages(): array
    {
        return [
            ProductTagIndexPage::class,
            ProductTagFormPage::class,
        ];
    }
}
