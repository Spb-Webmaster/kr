<?php

namespace App\MoonShine\Fields;

use Illuminate\Contracts\Support\Renderable;
use MoonShine\UI\Fields\Field;

class OrderPaperCreate extends Field
{
    protected string $view = 'moonshine.fields.order-paper-create';

    protected function viewData(): array
    {
        $model = $this->getData()?->getOriginal();

        return [
            'productId'    => $model?->id,
            'createUrl'    => route('moonshine.order-paper.create'),
            'papersCount'  => $model?->orderPapers()->count() ?? 0,
        ];
    }

    protected function resolvePreview(): Renderable|string
    {
        return '';
    }

    protected function resolveOnApply(): ?\Closure
    {
        return null;
    }
}
