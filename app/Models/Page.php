<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';

    protected $casts = [
        'gallery' => 'collection',
        'params'  => 'collection',
    ];

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'desc',
        'img',
        'desc2',
        'gallery',
        'params',
        'published',
        'metatitle',
        'description',
        'keywords',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::deleted(function ($model) {
            cache_clear();
        });

        # Выполняем действия после сохранения
        static::saved(function ($model) {
            cache_clear();
        });


    }
}
