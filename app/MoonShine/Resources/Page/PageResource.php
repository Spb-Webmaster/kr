<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Page;

use App\Models\Page;
use App\MoonShine\Resources\Page\Pages\PageIndexPage;
use App\MoonShine\Resources\Page\Pages\PageFormPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

/**
 * @extends ModelResource<Page, PageIndexPage, PageFormPage>
 */
class PageResource extends ModelResource
{
    protected string $model = Page::class;
    protected string $title = 'Страницы';
    protected string $column = 'title';

    public function search(): array
    {
        return ['title', 'slug'];
    }

    protected function pages(): array
    {
        return [
            PageIndexPage::class,
            PageFormPage::class,
        ];
    }
}
