<?php

namespace Domain\Product\ViewModel;

use App\Models\AgeRestriction;
use App\Models\City;
use App\Models\PersonCount;
use App\Models\Product;
use App\Models\ProductPriceOption;
use Domain\ProductCategory\ViewModel\ProductCategoryViewModel;
use Domain\ProductTag\ViewModel\ProductTagViewModel;
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

    public function productsByVendor(int $vendorId): LengthAwarePaginator
    {
        return Product::query()
            ->where('vendor_id', $vendorId)
            ->withCount(['orderPapers' => fn($q) => $q->where('vendor_id', $vendorId)])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
    }

    public function productOfVendor(int $vendorId, int $id): Product
    {
        return Product::query()
            ->where('vendor_id', $vendorId)
            ->where('id', $id)
            ->withCount(['orderPapers' => fn($q) => $q->where('vendor_id', $vendorId)])
            ->firstOrFail();
    }

    public function update(Product $product, array $data, array $categoryIds = [], array $tagIds = []): Product
    {
        $product->update($data);

        $product->categories()->sync($categoryIds);
        $product->tags()->sync($tagIds);

        return $product;
    }

    public function formData(): array
    {
        $cities = City::query()
            ->select('id', 'title')
            ->orderBy('sorting', 'desc')
            ->get()
            ->map(fn($item) => ['key' => $item->id, 'value' => $item->title])
            ->values()
            ->all();

        $personCounts = PersonCount::query()
            ->select('id', 'title')
            ->orderBy('sorting', 'desc')
            ->get()
            ->map(fn($item) => ['key' => $item->id, 'value' => $item->title])
            ->values()
            ->all();

        $ageRestrictions = AgeRestriction::query()
            ->select('id', 'title')
            ->orderBy('sorting', 'desc')
            ->get()
            ->map(fn($item) => ['key' => $item->id, 'value' => $item->title])
            ->values()
            ->all();

        $categories = ProductCategoryViewModel::make()->productCategory();
        $tags = ProductTagViewModel::make()->tags();

        $priceOptions = ProductPriceOption::query()
            ->select('id', 'title')
            ->orderBy('sorting', 'desc')
            ->get();

        return compact('cities', 'personCounts', 'ageRestrictions', 'categories', 'tags', 'priceOptions');
    }

    public function create(array $data, array $categoryIds = [], array $tagIds = []): Product
    {
        $product = Product::create($data);

        if ($categoryIds) {
            $product->categories()->sync($categoryIds);
        }

        if ($tagIds) {
            $product->tags()->sync($tagIds);
        }

        return $product;
    }

    public function delete(Product $product): void
    {
        $product->categories()->detach();
        $product->tags()->detach();
        $product->delete();
    }
}
