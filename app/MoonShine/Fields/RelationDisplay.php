<?php

namespace App\MoonShine\Fields;

use Illuminate\Contracts\Support\Renderable;
use MoonShine\UI\Fields\Field;

class RelationDisplay extends Field
{
    protected string $view = 'moonshine.fields.relation-display';

    private ?\Closure $formatter = null;

    public function display(\Closure $formatter): static
    {
        $this->formatter = $formatter;

        return $this;
    }

    private function getRelatedValue(): string
    {
        $model   = $this->getData()?->getOriginal();
        $related = $model?->{$this->getColumn()};

        if (!$related) {
            return '—';
        }

        if ($this->formatter) {
            return ($this->formatter)($related);
        }

        return (string) $related;
    }

    protected function resolvePreview(): Renderable|string
    {
        return $this->getRelatedValue();
    }

    protected function viewData(): array
    {
        return [
            'relatedDisplay' => $this->getRelatedValue(),
        ];
    }
}
