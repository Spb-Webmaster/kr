<?php

namespace Domain\City\ViewModel;

use App\Models\City;
use Illuminate\Database\Eloquent\Collection;
use Support\Traits\Makeable;

class CityViewModel
{
    use Makeable;

    public function cities(): ?Collection
    {
        return City::query()
            ->orderBy('sorting', 'desc')
            ->get();
    }
}
