<?php

namespace App\Http\Controllers;

use Domain\Product\ViewModel\ProductViewModel;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    public function index(string $category): View
    {
        $products = $category === 'all'
            ? ProductViewModel::make()->products()
            : ProductViewModel::make()->productsByCategory($category);

        return view('products.products', compact('products', 'category'));
    }

    public function show(string $slug): View
    {
        $product = ProductViewModel::make()->product($slug);

        return view('products.product', compact('product'));
    }
}
