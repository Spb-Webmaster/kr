<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Taxation;

use Illuminate\Database\Eloquent\Model;
use App\Models\Taxation;
use App\MoonShine\Resources\Taxation\Pages\TaxationIndexPage;
use App\MoonShine\Resources\Taxation\Pages\TaxationFormPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

/**
 * @extends ModelResource<Taxation, TaxationIndexPage, TaxationFormPage>
 */
class TaxationResource extends ModelResource
{
    protected string $model = Taxation::class;

    protected string $title = 'Система налогов';

    protected string $sortColumn = 'sorting';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            TaxationIndexPage::class,
            TaxationFormPage::class,
        ];
    }
}
