<?php

namespace App\Models;

use App\Enum\CertificateStatus;
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
        'certificate_status',
    ];
    protected $casts = [
        'order' => 'collection',
        'notification_yoo_kassa' => 'collection',
        'certificate_status' => CertificateStatus::class,
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
