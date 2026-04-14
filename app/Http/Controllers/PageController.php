<?php

namespace App\Http\Controllers;

use Domain\Page\ViewModels\PageViewModel;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{

    public function page($slug): View
    {
        $item = PageViewModel::make()->page($slug);
        return view('pages.page', [
            'item' => $item
        ]);
    }
}
