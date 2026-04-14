<?php

namespace App\View\Components\Site\Catalog\Category;

use App\Models\ProductCategory;
use Closure;
use Domain\ProductCategory\ViewModel\ProductCategoryViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Category extends Component
{
    public ?object $product_categories;
    public function __construct()
    {
        $this->product_categories = ProductCategoryViewModel::make()->productCategory();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.site.catalog.category.category');
    }
}
