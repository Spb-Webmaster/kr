<?php

namespace App\Models;

use App\Enum\CertificateStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderPaper extends Model
{
    protected $table = 'order_papers';

    protected $fillable = [
        'number',
        'vendor_id',
        'product_id',
        'price',
        'price_option',
        'certificate_status',
    ];

    protected $casts = [
        'certificate_status' => CertificateStatus::class,
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
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
