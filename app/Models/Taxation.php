<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Taxation extends Model
{
    protected $table = 'taxations'; // Система налогообложения
    protected $fillable = [
        'title',
        'subtitle',
        'sorting',
    ];

    /**
     * @return HasMany
     * Имеет много юр. лиц
     */
    public function legalEntity(): HasMany
    {
        return $this->hasMany(LegalEntity::class);
    }

    /**
     * @return HasMany
     * Имеет индивидуальных предпринимателей
     */
    public function individualEntrepreneur(): HasMany
    {
        return $this->hasMany(IndividualEntrepreneur::class);
    }


    protected function casts(): array
    {
        return [];
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
