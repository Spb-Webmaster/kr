<?php

namespace App\Livewire;

use App\Models\City;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductTag;
use Livewire\Attributes\Url;
use Livewire\Component;

class ProductCatalog extends Component
{
    /** Slug категории из URL маршрута (например 'all', 'adventure'). Не меняется через Livewire. */
    public string $category = 'all';

    #[Url]
    public array $selectedTags = [];

    #[Url]
    public array $selectedCities = [];

    #[Url]
    public array $selectedCategories = [];

    #[Url]
    public int $priceMin = 0;

    #[Url]
    public int $priceMax = 0;

    /** Вызывается кнопкой «Показать» — применяет ценовой диапазон из JS-слайдера */
    public function applyPriceFilter(int $min, int $max): void
    {
        $this->priceMin = $min;
        $this->priceMax = $max;
    }

    public function mount(string $category = 'all'): void
    {
        $this->category = $category;

        if ($this->priceMin === 0) {
            $this->priceMin = $this->resolveMinPrice();
        }

        if ($this->priceMax === 0) {
            $this->priceMax = $this->resolveMaxPrice();
        }
    }

    private function resolveAllPrices(): \Illuminate\Support\Collection
    {
        $products = Product::query()->where('published', 1)->get();

        return $products->flatMap(function ($product) {
            if (!empty($product->price) && (int) $product->price > 0) {
                return [(int) $product->price];
            }

            if (!empty($product->prices) && $product->prices->isNotEmpty()) {
                // Возвращаем все цены из опций, чтобы max() находил реальный максимум
                return $product->prices
                    ->map(fn($item) => (int) (is_array($item) ? $item['price'] : $item->price))
                    ->filter(fn($p) => $p > 0)
                    ->values()
                    ->all();
            }

            return [];
        })->filter(fn($v) => $v > 0);
    }

    private function resolveMinPrice(): int
    {
        $prices = $this->resolveAllPrices();

        return $prices->isEmpty() ? 0 : (int) $prices->min();
    }

    private function resolveMaxPrice(): int
    {
        $prices = $this->resolveAllPrices();

        return $prices->isEmpty() ? 100000 : (int) $prices->max();
    }

    public function render()
    {
        $query = Product::query()->where('published', 1);

        // Фильтр по slug категории из URL (например /adventure/certificates)
        if ($this->category !== 'all') {
            $query->whereHas('categories', fn($q) => $q->where('slug', $this->category));
        }

        // Дополнительный фильтр по категориям из левой панели (по ID)
        if (!empty($this->selectedCategories)) {
            $query->whereHas('categories', fn($q) => $q->whereIn('product_categories.id', $this->selectedCategories));
        }

        if (!empty($this->selectedTags)) {
            $query->whereHas('tags', fn($q) => $q->whereIn('product_tags.id', $this->selectedTags));
        }

        if (!empty($this->selectedCities)) {
            $query->whereIn('city_id', $this->selectedCities);
        }

        $query->where(function ($q) {
            // Продукты с единственной ценой — фильтруем по диапазону
            $q->where(function ($q2) {
                $q2->whereNotNull('price')
                    ->where('price', '>=', $this->priceMin)
                    ->where('price', '<=', $this->priceMax);
            })
            // Продукты с JSON-ценами — фильтруем через JSON_TABLE (MySQL 8+):
            // показываем, если хотя бы одна опция попадает в диапазон
            ->orWhere(function ($q2) {
                $q2->whereRaw("JSON_LENGTH(prices) > 0")
                    ->whereRaw("EXISTS (
                        SELECT 1
                        FROM JSON_TABLE(products.prices, '\$[*]' COLUMNS (jt_price INT PATH '\$.price')) AS jt
                        WHERE jt.jt_price >= ? AND jt.jt_price <= ?
                    )", [$this->priceMin, $this->priceMax]);
            });
        });

        $products   = $query->get();
        $tags       = ProductTag::query()->where('published', 1)->orderByDesc('sorting')->get();
        $cities     = City::query()->orderByDesc('sorting')->get();
        $categories = ProductCategory::query()->orderByDesc('sorting')->get();

        return view('livewire.product-catalog', compact('products', 'tags', 'cities', 'categories'));
    }
}
