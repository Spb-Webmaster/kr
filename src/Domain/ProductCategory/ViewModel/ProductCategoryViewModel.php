<?php

namespace Domain\ProductCategory\ViewModel;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Makeable;

class ProductCategoryViewModel
{
    use Makeable;

    public function productCategory():Collection
    {
        return ProductCategory::query()
            ->where('published', 1)
            ->get();
    }
}
