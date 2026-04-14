<?php

namespace App\MoonShine\Fields;

use Illuminate\Contracts\Support\Renderable;
use MoonShine\UI\Fields\Field;

class MinPrice extends Field
{
    protected string $view = 'moonshine.fields.min-price';

    private function getMinPrice(): ?int
    {
        $model = $this->getData()->getOriginal();
        $prices = $model->prices;

        if ($prices && $prices->isNotEmpty()) {
            return $prices->min(fn($item) => (int) (is_array($item) ? $item['price'] : $item->price));
        }

        return null;
    }

    protected function resolvePreview(): Renderable|string
    {
        $min = $this->getMinPrice();

        return $min !== null ? (string) $min : '—';
    }

    protected function viewData(): array
    {
        return [
            'min' => $this->getMinPrice(),
        ];
    }
}
