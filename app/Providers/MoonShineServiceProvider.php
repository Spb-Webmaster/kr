<?php

declare(strict_types=1);

namespace App\Providers;

use App\MoonShine\Resources\Page\PageResource;
use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShine;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;
use App\MoonShine\Resources\MoonShineUser\MoonShineUserResource;
use App\MoonShine\Resources\MoonShineUserRole\MoonShineUserRoleResource;
use App\MoonShine\Pages\HomePage;
use App\MoonShine\Pages\SettingPage;
use App\MoonShine\Resources\User\UserResource;
use App\MoonShine\Resources\Vendor\VendorResource;
use App\MoonShine\Resources\LegalEntity\LegalEntityResource;
use App\MoonShine\Resources\IndividualEntrepreneur\IndividualEntrepreneurResource;
use App\MoonShine\Resources\SelfEmployed\SelfEmployedResource;
use App\MoonShine\Resources\City\CityResource;
use App\MoonShine\Resources\Taxation\TaxationResource;
use App\MoonShine\Resources\PersonCount\PersonCountResource;
use App\MoonShine\Resources\AgeRestriction\AgeRestrictionResource;
use App\MoonShine\Resources\ProductCategory\ProductCategoryResource;
use App\MoonShine\Resources\Product\ProductResource;
use App\MoonShine\Resources\ProductTag\ProductTagResource;
use App\MoonShine\Resources\Order\OrderResource;
use App\MoonShine\Resources\OrderPaper\OrderPaperResource;
use App\MoonShine\Resources\ProductPriceOption\ProductPriceOptionResource;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  CoreContract<MoonShineConfigurator>  $core
     */
    public function boot(CoreContract $core): void
    {
        $core
            ->resources([
                MoonShineUserResource::class,
                MoonShineUserRoleResource::class,
                UserResource::class,
                VendorResource::class,
                LegalEntityResource::class,
                IndividualEntrepreneurResource::class,
                SelfEmployedResource::class,
                CityResource::class,
                TaxationResource::class,
                ProductCategoryResource::class,
                ProductResource::class,
                PersonCountResource::class,
                AgeRestrictionResource::class,
                ProductTagResource::class,
                PageResource::class,
                ProductPriceOptionResource::class,
                OrderResource::class,
                OrderPaperResource::class,
            ])
            ->pages([
                ...$core->getConfig()->getPages(),
                HomePage::class,
                SettingPage::class,
            ])
        ;
    }
}
