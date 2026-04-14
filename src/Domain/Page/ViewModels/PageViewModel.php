<?php

namespace Domain\Page\ViewModels;

use App\Models\Page;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Makeable;

class PageViewModel
{
    use Makeable;

    public function page($slug):model | null
    {
        return Page::query()
            ->where('slug', $slug)
            ->where('published', 1)
            ->firstOrFail();
    }
}
