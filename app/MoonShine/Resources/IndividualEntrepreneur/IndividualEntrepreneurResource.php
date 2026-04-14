<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\IndividualEntrepreneur;

use Illuminate\Database\Eloquent\Model;
use App\Models\IndividualEntrepreneur;
use App\MoonShine\Resources\IndividualEntrepreneur\Pages\IndividualEntrepreneurIndexPage;
use App\MoonShine\Resources\IndividualEntrepreneur\Pages\IndividualEntrepreneurFormPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

/**
 * @extends ModelResource<IndividualEntrepreneur, IndividualEntrepreneurIndexPage, IndividualEntrepreneurFormPage>
 */
class IndividualEntrepreneurResource extends ModelResource
{
    protected string $model = IndividualEntrepreneur::class;

    protected string $title = 'Индивидуальные предприниматели';

    protected string $column    = 'name';

    public function search(): array
    {
        return ['name','full_name', 'email', 'phone', 'register_address', 'address', 'inn',  'ogrnip', 'bank', 'bik', 'vendor.username', 'vendor.surname' ,'correspondent_account','payment_account', 'okved'];
    }
    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            IndividualEntrepreneurIndexPage::class,
            IndividualEntrepreneurFormPage::class,
        ];
    }
}
