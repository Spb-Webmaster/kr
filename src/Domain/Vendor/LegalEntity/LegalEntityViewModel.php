<?php

namespace Domain\Vendor\LegalEntity;

use App\Enum\Moonshine\PaymentNdsEnum;
use App\Models\LegalEntity;
use Domain\Vendor\DTOs\LegalEntityDto;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Makeable;

class LegalEntityViewModel
{
    use Makeable;

    public function create($request): ?Model
    {
        $data = LegalEntityDto::formRequest($request);
        return LegalEntity::create($data->toArray());

    }
    public function update($model, $request): void
    {
        $model->update([
            'name'                  => $request->le_name,
            'full_name'             => $request->le_full_name,
            'legal_address'         => $request->legal_address,
            'address'               => $request->address,
            'kpp'                   => $request->kpp,
            'ogrn'                  => $request->ogrn,
            'director'              => $request->director,
            'accountant'            => $request->accountant,
            'person_contract'       => $request->person_contract,
            'bank'                  => $request->bank,
            'bik'                   => $request->bik,
            'okved'                 => $request->okved,
            'correspondent_account' => $request->correspondent_account,
            'payment_account'       => $request->payment_account,
            'taxation_id'           => $request->taxation_id,
            'payment_nds'           => $request->payment_nds,
        ]);
    }

    public function render($model): ?array
    {

        try {
            $data = LegalEntityDto::model($model);

            return [
                config('site.constants.name') => $data->name,
                config('site.constants.full_name') => $data->full_name,
                config('site.constants.legal_address') => $data->legal_address,
                config('site.constants.address') => $data->address,
                config('site.constants.kpp') => $data->kpp,
                config('site.constants.ogrn') => $data->ogrn,
                config('site.constants.bank') => $data->bank,
                config('site.constants.director') => $data->director,
                config('site.constants.accountant') => $data->accountant,
                config('site.constants.person_contract') => $data->person_contract,
                config('site.constants.bik') => $data->bik,
                config('site.constants.okved') => $data->okved,
                config('site.constants.correspondent_account') => $data->correspondent_account,
                config('site.constants.payment_account') => $data->payment_account,
                config('site.constants.taxation') => (isset($model->taxation))?$model->taxation->title: ' - ',
                config('site.constants.payment_nds') => PaymentNdsEnum::fromValue($data->payment_nds),
            ];
        } catch (\Throwable $th) {
            // Обрабатываем исключение
            logErrors($th);
            return null;
        }

    }

}
