<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use LogicException;
use App\Models\AgeRestriction;
use App\Models\City;
use App\Models\PersonCount;
use App\Models\Vendor;

class Product extends Model
{

    protected $table='products';

    protected $fillable = [
        'title',
        'subtitle',
        'desc',
        'img',
        'desc2',
        'gallery',
        'params',
        'published',
        'sorting',
        'person_count_id',  //количество человек
        'age_restriction_id', //возрастное ограничение
        'weather', //погода
        'other_info', //дополнительная информация
        'special_clothing', //спецодежда
        'slug',
        'metatitle',
        'description',
        'keywords',
        'vendor_id',
        'city_id',
        'price',
        'prices',
    ];

    protected $casts = [
        'params' => 'collection',
        'gallery' => 'collection',
        'prices' => 'collection',
        ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class, 'category_product');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(ProductTag::class, 'product_tag');
    }

    public function personCount(): BelongsTo
    {
        return $this->belongsTo(PersonCount::class, 'person_count_id');
    }

    public function ageRestriction(): BelongsTo
    {
        return $this->belongsTo(AgeRestriction::class, 'age_restriction_id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'product_id');
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class, 'product_id');
    }

    protected function pricesList(): Attribute
    {
        return Attribute::make(
            get: function (): Collection {
                if (empty($this->prices) || $this->prices->isEmpty()) {
                    return collect();
                }

                $options = ProductPriceOption::query()
                    ->whereIn('id', $this->prices->pluck('option_id'))
                    ->pluck('title', 'id');

                return $this->prices->map(function ($item) use ($options) {
                    $optionId = is_array($item) ? $item['option_id'] : $item->option_id;
                    $itemPrice = is_array($item) ? $item['price'] : $item->price;

                    return [
                        'option' => $options->get($optionId, '—'),
                        'price'  => price($itemPrice),
                    ];
                });
            }
        );
    }

    protected function displayPrice(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!empty($this->price) && (int) $this->price > 0) {
                    return price($this->price);
                }

                if (!empty($this->prices) && $this->prices->isNotEmpty()) {
                    $min = $this->prices->min(fn($item) => (int) (is_array($item) ? $item['price'] : $item->price));
                    return 'от ' . price($min);
                }

                return null;
            }
        );
    }

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            $priceEmpty  = empty($model->price) || (int) $model->price === 0;
            $pricesEmpty = empty($model->prices) || $model->prices->isEmpty();

            if ($priceEmpty && $pricesEmpty) {
                throw new LogicException('Необходимо указать обычную цену или хотя бы одну цену с опцией.');
            }
        });

        static::deleted(function ($model) {
            cache_clear();
        });

        # Выполняем действия после сохранения
        static::saved(function ($model) {
            cache_clear();
        });


    }
}
