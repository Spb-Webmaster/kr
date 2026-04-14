<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Vendor;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vendor;
use App\MoonShine\Resources\Vendor\Pages\VendorIndexPage;
use App\MoonShine\Resources\Vendor\Pages\VendorFormPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

/**
 * @extends ModelResource<Vendor, VendorIndexPage, VendorFormPage>
 */
class VendorResource extends ModelResource
{
    protected string $model = Vendor::class;

    protected string $title = 'Продавцы услуг';
    protected string $sortColumn = 'created_at';

    protected string $column = 'surname';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            VendorIndexPage::class,
            VendorFormPage::class,
        ];
    }
}
