<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\LegalEntity;

use Illuminate\Database\Eloquent\Model;
use App\Models\LegalEntity;
use App\MoonShine\Resources\LegalEntity\Pages\LegalEntityIndexPage;
use App\MoonShine\Resources\LegalEntity\Pages\LegalEntityFormPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

/**
 * @extends ModelResource<LegalEntity, LegalEntityIndexPage, LegalEntityFormPage>
 */
class LegalEntityResource extends ModelResource
{
    protected string $model = LegalEntity::class;

    protected string $title = 'Юридические лица';

    protected string $column    = 'name';

    public function search(): array
    {
        return ['name', 'full_name', 'email', 'phone', 'address', 'inn', 'kpp', 'ogrn', 'director', 'person_contract', 'bank', 'bik', 'vendor.username' , 'vendor.surname' ,'correspondent_account','payment_account', 'okved'];
    }
    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            LegalEntityIndexPage::class,
            LegalEntityFormPage::class,
        ];
    }
}
