<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPriceOption extends Model
{
    protected $table = 'product_price_options';

    protected $fillable = [
        'title',
        'sorting',
    ];
}
