<?php

namespace Domain\Product\ViewModel;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Support\Traits\Makeable;

class ProductViewModel
{
    use Makeable;

    public function products(): ?LengthAwarePaginator
    {
        return Product::query()
            ->where('published', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(config("site.constants.paginate"));
    }

    public function productsByCategory(string $slug): ?LengthAwarePaginator
    {
        return Product::query()
            ->where('published', 1)
            ->whereHas('categories', fn($q) => $q->where('slug', $slug))
            ->orderBy('created_at', 'desc')
            ->paginate(config("site.constants.paginate"));
    }

    public function product(string $slug): ?Product
    {
        return Product::query()
            ->where('published', 1)
            ->where('slug', $slug)
            ->firstOrFail();
    }
}
