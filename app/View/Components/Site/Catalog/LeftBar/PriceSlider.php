<?php

namespace App\View\Components\Site\Catalog\LeftBar;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PriceSlider extends Component
{
    /** Текущее выбранное значение фильтра (value инпута) */
    public int $minPrice;
    public int $maxPrice;

    /** Абсолютный диапазон по всем товарам (data-min / data-max слайдера, не меняется) */
    public int $absoluteMin;
    public int $absoluteMax;

    public ?string $wireMin;
    public ?string $wireMax;

    public function __construct(
        int $minPrice = 0,
        int $maxPrice = 0,
        ?string $wireMin = null,
        ?string $wireMax = null,
    ) {
        // Абсолютный диапазон всегда вычисляется здесь — это границы слайдера
        [$this->absoluteMin, $this->absoluteMax] = $this->resolvePriceRange();

        // Текущие значения фильтра: если не переданы — берём абсолютные границы
        $this->minPrice = $minPrice ?: $this->absoluteMin;
        $this->maxPrice = $maxPrice ?: $this->absoluteMax;

        $this->wireMin = $wireMin;
        $this->wireMax = $wireMax;
    }

    private function resolvePriceRange(): array
    {
        $allPrices = [];

        // Продукты с единственной ценой
        Product::query()
            ->where('published', 1)
            ->where('price', '>', 0)
            ->pluck('price')
            ->each(fn($p) => $allPrices[] = (int) $p);

        // Продукты с JSON-ценами: get() применяет каст модели,
        // поэтому $product->prices — это уже Collection, а не строка
        Product::query()
            ->where('published', 1)
            ->whereNotNull('prices')
            ->get(['prices'])
            ->each(function ($product) use (&$allPrices) {
                foreach ($product->prices as $item) {
                    $p = (int) (is_array($item) ? ($item['price'] ?? 0) : ($item->price ?? 0));
                    if ($p > 0) {
                        $allPrices[] = $p;
                    }
                }
            });

        if (empty($allPrices)) {
            return [0, 100000];
        }

        return [min($allPrices), max($allPrices)];
    }

    public function render(): View|Closure|string
    {
        return view('components.site.catalog.left-bar.price-slider');
    }
}
