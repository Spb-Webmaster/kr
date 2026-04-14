<?php

namespace App\View\Composers;

use App\Enum\Moonshine\PaymentNdsEnum;
use App\Enum\TypeEnum;
use App\Models\City;
use App\Models\Taxation;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use ReflectionEnum;

class VendorSignUpComposer
{
    public function compose(View $view): void
    {
        // Передаем массив в представление
        $types =  TypeEnum::toArray();
        $payment_nds = PaymentNdsEnum::toArray();
        $cities =  City::query()->select('id','title')->get()->map(function ($item) {
            return [
                'key' => $item['id'],
                'value' => $item['title']
            ];
        })->values()->all();
        $taxations = Taxation::query()->select('id','title')->get()->map(function ($item) {
            return [
                'key'   => $item['id'],
                'value' => $item['title']
            ];
        })->values()->all();

        $view->with(compact('types', 'payment_nds', 'taxations', 'cities'));

    }

}
