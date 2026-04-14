<?php

namespace App\View\Components\Site\Catalog\LeftBar;

use App\Models\ProductTag;
use Closure;
use Domain\ProductTag\ViewModel\ProductTagViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tags extends Component
{
    public function __construct(public ?object $tags = null)
    {
        $this->tags = ProductTagViewModel::make()->tags();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.site.catalog.left-bar.tags');
    }

}
