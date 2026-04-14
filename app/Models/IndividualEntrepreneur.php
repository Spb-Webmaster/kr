<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndividualEntrepreneur extends Model
{
   protected $table = 'individual_entrepreneurs';
    protected $fillable = [
        'vendor_id',
        'name',
        'full_name',
        'register_address',
        'email',
        'phone',
        'address',
        'inn',
        'ogrnip',
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
