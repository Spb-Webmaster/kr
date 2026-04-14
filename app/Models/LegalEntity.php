<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class LegalEntity extends Model
{
    protected $table = 'legal_entities';
    protected $fillable = [
        'vendor_id',
        'name',
        'full_name',
        'legal_address',
        'email',
        'phone',
        'address',
        'inn',
        'kpp',
        'ogrn',
        'director',
        'accountant',
        'person_contract',
        'bank',
        'bik',
        'correspondent_account',
        'payment_account',
        'okved',
        'payment_nds',
        'taxation_id'
    ];

    /**
     * Отношение с продавцом
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    /**
     * Система налогообложения
     */
    public function taxation(): BelongsTo
    {
        return $this->belongsTo(Taxation::class, 'taxation_id');
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
