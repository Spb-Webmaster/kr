<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\AgeRestriction;

use Illuminate\Database\Eloquent\Model;
use App\Models\AgeRestriction;
use App\MoonShine\Resources\AgeRestriction\Pages\AgeRestrictionIndexPage;
use App\MoonShine\Resources\AgeRestriction\Pages\AgeRestrictionFormPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

/**
 * @extends ModelResource<AgeRestriction, AgeRestrictionIndexPage, AgeRestrictionFormPage>
 */
class AgeRestrictionResource extends ModelResource
{
    protected string $model = AgeRestriction::class;

    protected string $title = 'Возрастные ограничения';

    protected string $sortColumn = 'sorting';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            AgeRestrictionIndexPage::class,
            AgeRestrictionFormPage::class,
        ];
    }
}
