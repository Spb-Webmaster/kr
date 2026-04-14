<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SelfEmployed extends Model
{
    protected $table = 'self_employeds';
    protected $fillable = [
        'vendor_id',
        'register_address',
        'email',
        'phone',
        'address',
        'inn',
        'passport_serial',
        'passport_number',
        'who_issued',
        'date_issued',
        'bank',
        'bik',
        'correspondent_account',
        'payment_account',
    ];

    /**
     * Отношение с продавцом
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
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
