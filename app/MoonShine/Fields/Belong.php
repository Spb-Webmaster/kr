<?php

namespace App\MoonShine\Fields;

use App\Enum\TypeEnum;
use App\Models\IndividualEntrepreneur;
use App\Models\LegalEntity;
use App\Models\SelfEmployed;
use Illuminate\Support\Facades\Storage;
use MoonShine\UI\Fields\Field;

class Belong extends Field
{
    protected string $view = 'moonshine.fields.belong';

    public string $params;
    protected function fields():array | bool
    {

        $id = $this->getData()->getKey();
        if ($id) {
            $model = $this->getData();

            if ($model->legalEntity instanceof LegalEntity) {
                $array['model'] =  $model->legalEntity->toArray();
                $array['type'] = TypeEnum::LEGALENTITY->toString();
                return $array;
            }

            if ($model->individualEntrepreneur instanceof IndividualEntrepreneur) {
                $array['model'] =  $model->individualEntrepreneur->toArray();
                $array['type'] = TypeEnum::INDIVIDUALENTREPRENEUR->toString();
                return $array;
            }

            if ($model->selfEmployed instanceof SelfEmployed) {
                $array['model'] =  $model->selfEmployed->toArray();
                $array['type'] = TypeEnum::SELFEMPLOYED->toString();
                return $array;
            }

            return false;

        }
        return false;

    }


    protected function viewData(): array
    {
        return [
            'array' => $this->fields(),
        ];
    }
}
