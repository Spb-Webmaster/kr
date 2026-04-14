<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Support\Casts\TicketCast;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'number',
        'title',
        'username',
        'email',
        'phone',
        'price',
        'price_option',
        'status',
        'notification_yoo_kassa',
        'status_yoo_kassa',
        'id_yoo_kassa',
        'order_id',
        'product_id',
        'user_id',
        'vendor_id',
        'certificate_id',
    ];
    protected $casts = [
        'order' => 'collection',
        'notification_yoo_kassa' => 'collection',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function certificate(): HasOne
    {
        return $this->hasOne(Certificate::class, 'order_id');
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
