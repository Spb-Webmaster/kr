<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgeRestriction extends Model
{
    /** Возрастное ограничение */
    protected $table = 'age_restrictions';
    protected $fillable = [
        'title',
        'subtitle',
        'sorting',
    ];



    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'age_restriction_id');
    }

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
