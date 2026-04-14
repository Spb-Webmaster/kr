<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PersonCount extends Model
{
/** Количество человек */
    protected $table = 'person_counts';
    protected $fillable = [
        'title',
        'subtitle',
        'sorting',
    ];



    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'person_count_id');
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
