<?php

namespace Domain\ProductTag\ViewModel;

use App\Models\ProductTag;
use Illuminate\Database\Eloquent\Collection;
use Support\Traits\Makeable;

class ProductTagViewModel
{
    use Makeable;

    public function tags():?Collection
    {
        return ProductTag::query()
            ->where('published', 1)
            ->get();

    }
}
