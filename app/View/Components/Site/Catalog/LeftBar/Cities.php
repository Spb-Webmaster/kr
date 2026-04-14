<?php

namespace App\View\Components\Site\Catalog\LeftBar;

use Closure;
use Domain\City\ViewModel\CityViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Cities extends Component
{
    public function __construct(public ?object $cities = null)
    {
        $this->cities = CityViewModel::make()->cities();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.site.catalog.left-bar.cities');
    }
}
