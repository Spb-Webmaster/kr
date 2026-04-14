<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\LegalEntity\Pages;

use App\MoonShine\Resources\Vendor\VendorResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Contracts\Core\DependencyInjection\CrudRequestContract;
use MoonShine\Crud\JsonResponse;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Support\Attributes\AsyncMethod;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\QueryTags\QueryTag;
use MoonShine\UI\Components\Metrics\Wrapped\Metric;
use MoonShine\UI\Fields\ID;
use App\MoonShine\Resources\LegalEntity\LegalEntityResource;
use MoonShine\Support\ListOf;
use MoonShine\UI\Fields\Text;
use Throwable;
use Faker\Factory as FakerFactory;


/**
 * @extends IndexPage<LegalEntityResource>
 */
class LegalEntityIndexPage extends IndexPage
{
    protected bool $isLazy = true;

    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            Text::make('Полное наименование', 'name'),
            Text::make('Email', 'email'),
            Text::make('ИНН', 'inn'),
            Text::make('Банк', 'bank'),
            BelongsTo::make('Продавец', 'vendor', 'surname', resource: VendorResource::class)->nullable(),
        ];
    }



    /**
     * @return list<FieldContract>
     */
    protected function filters(): iterable
    {
        return [
            Text::make('Юр лицо', 'name'),
            Text::make('ИНН', 'inn'),
            BelongsTo::make('Продавец  - Имя', 'vendor', 'username', resource: VendorResource::class)->nullable(),
            BelongsTo::make('Продавец  - Фамилия', 'vendor', 'surname', resource: VendorResource::class)->nullable(),
            ];
    }

    /**
     * @return list<QueryTag>
     */
    protected function queryTags(): array
    {
        return [];
    }

    /**
     * @return list<Metric>
     */
    protected function metrics(): array
    {
        return [];
    }

    /**
     * @param  TableBuilder  $component
     *
     * @return TableBuilder
     */
    protected function modifyListComponent(ComponentContract $component): ComponentContract
    {
        return $component;
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function topLayer(): array
    {
        return [
            ...parent::topLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer()
        ];
    }

    protected function buttons(): ListOf
    {
        return parent::buttons()
            ->add(
                ActionButton::make('Clone')
                    ->icon('document-duplicate')
                    ->method('duplicateRow')
                    ->withConfirm('Clone this row?', 'Сохраняется с заменой  полей "email" и  поля "phone", исправьте это вручную.')
            );
    }


    #[AsyncMethod]
    public static function duplicateRow(CrudRequestContract $request, JsonResponse $response)
    {
        $resource = $request->getResource();

        /** @var Model $newItem */
        $newItem = $resource?->getItem()->replicate();

// Создаем экземпляр фейкера
        $faker = FakerFactory::create();
        $newItem->phone = '7' . random_int(1000000000, 9999999999);

        $newItem->email = $faker->email;
        $newItem->save();

        $url = $resource?->getFormPageUrl($newItem->id);

        //return $response->redirect($url);
        return redirect()->back();
    }

}
