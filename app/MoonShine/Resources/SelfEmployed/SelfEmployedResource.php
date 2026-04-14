<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\SelfEmployed;

use Illuminate\Database\Eloquent\Model;
use App\Models\SelfEmployed;
use App\MoonShine\Resources\SelfEmployed\Pages\SelfEmployedIndexPage;
use App\MoonShine\Resources\SelfEmployed\Pages\SelfEmployedFormPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

/**
 * @extends ModelResource<SelfEmployed, SelfEmployedIndexPage, SelfEmployedFormPage>
 */
class SelfEmployedResource extends ModelResource
{
    protected string $model = SelfEmployed::class;

    protected string $title = 'Самозанятые';

    protected string $column = 'inn';

    public function search(): array
    {
        return ['email', 'phone',  'inn', 'passport_number',  'bank', 'bik', 'vendor.username', 'vendor.surname' ];
    }
    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            SelfEmployedIndexPage::class,
            SelfEmployedFormPage::class,
        ];
    }
}
