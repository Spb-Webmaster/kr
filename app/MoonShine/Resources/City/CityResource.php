<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\City;

use Illuminate\Database\Eloquent\Model;
use App\Models\City;
use App\MoonShine\Resources\City\Pages\CityIndexPage;
use App\MoonShine\Resources\City\Pages\CityFormPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

/**
 * @extends ModelResource<City, CityIndexPage, CityFormPage>
 */
class CityResource extends ModelResource
{
    protected string $model = City::class;

    protected string $title = 'Города';

    protected string $sortColumn = 'sorting';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            CityIndexPage::class,
            CityFormPage::class,
        ];
    }
}
