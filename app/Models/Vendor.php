<?php

namespace App\Models;

use App\Enum\TypeEnum;
use Domain\Vendor\IndividualEntrepreneur\IndividualEntrepreneurViewModel;
use Domain\Vendor\LegalEntity\LegalEntityViewModel;
use Domain\Vendor\SelfEmployed\SelfEmployedViewModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Vendor extends Model
{
    protected $table = 'vendors';
    protected $fillable = [
        'username',
        'surname',
        'patronymic',
        'phone',
        'email',
        'about_me',
        'questionnaire',
        'password',
        'city_id'

    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'vendor_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'vendor_id');
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class, 'vendor_id');
    }

    /**
     * Отношение с юридическим лицом
     */
    public function legalEntity(): HasOne
    {
        return $this->hasOne(LegalEntity::class, 'vendor_id');
    }


    /**
     * Отношение с ИП
     */
    public function individualEntrepreneur(): HasOne
    {
        return $this->hasOne(IndividualEntrepreneur::class, 'vendor_id');
    }

    /**
     * Отношение с самозанятым
     */
    public function selfEmployed(): HasOne
    {
        return $this->hasOne(SelfEmployed::class, 'vendor_id');
    }

    public function getTypeAttribute(): string
    {
        if ($this->legalEntity instanceof LegalEntity) {
            return TypeEnum::LEGALENTITY->toString();
        }

        if ($this->individualEntrepreneur instanceof IndividualEntrepreneur) {
            return TypeEnum::INDIVIDUALENTREPRENEUR->toString();
        }

        if ($this->selfEmployed instanceof SelfEmployed) {
            return TypeEnum::SELFEMPLOYED->toString();
        }
        return '';
    }

    public function getArrayDataAttribute(): array
    {
        if ($this->legalEntity instanceof LegalEntity) {
            return LegalEntityViewModel::make()->render($this->legalEntity);
        }

        if ($this->individualEntrepreneur instanceof IndividualEntrepreneur) {
            return IndividualEntrepreneurViewModel::make()->render($this->individualEntrepreneur);
        }

        if ($this->selfEmployed instanceof SelfEmployed) {
            return SelfEmployedViewModel::make()->render($this->selfEmployed);
        }
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
