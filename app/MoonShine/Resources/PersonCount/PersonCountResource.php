<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\PersonCount;

use Illuminate\Database\Eloquent\Model;
use App\Models\PersonCount;
use App\MoonShine\Resources\PersonCount\Pages\PersonCountIndexPage;
use App\MoonShine\Resources\PersonCount\Pages\PersonCountFormPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

/**
 * @extends ModelResource<PersonCount, PersonCountIndexPage, PersonCountFormPage>
 */
class PersonCountResource extends ModelResource
{
    protected string $model = PersonCount::class;

    protected string $title = 'Кол-во человек';

    protected string $sortColumn = 'sorting';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            PersonCountIndexPage::class,
            PersonCountFormPage::class,
        ];
    }
}
