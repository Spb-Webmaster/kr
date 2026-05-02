<?php

namespace Domain\Vendor\SelfEmployed;

use App\Enum\Moonshine\PaymentNdsEnum;
use App\Models\SelfEmployed;
use Domain\Vendor\DTOs\SelfEmployedDto;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Makeable;

class SelfEmployedViewModel
{
    use Makeable;

    public function create($request): ?Model
    {
        $data = SelfEmployedDto::formRequest($request);
        return SelfEmployed::create($data->toArray());

    }

    public function update($model, $request): void
    {
        $model->update([
            'register_address'    => $request->register_address,
            'address'             => $request->address,
            'passport_serial'     => $request->passport_serial,
            'passport_number'     => $request->passport_number,
            'who_issued'          => $request->who_issued,
            'date_issued'         => $request->date_issued,
            'bank'                => $request->bank,
            'bik'                 => $request->bik,
            'correspondent_account' => $request->correspondent_account,
            'payment_account'     => $request->payment_account,
        ]);
    }

    public function render($model): ?array
    {

        try {
            $data = SelfEmployedDto::model($model);

            return [

                config('site.constants.register_address') => $data->register_address,
                config('site.constants.address') => $data->address,
                config('site.constants.passport_serial') => $data->passport_serial,
                config('site.constants.passport_number') => $data->passport_number,
                config('site.constants.who_issued') => $data->who_issued,
                config('site.constants.date_issued') => $data->date_issued,
                config('site.constants.bank') => $data->bank,
                config('site.constants.bik') => $data->bik,
                config('site.constants.correspondent_account') => $data->correspondent_account,
                config('site.constants.payment_account') => $data->payment_account,
            ];
        } catch (\Throwable $th) {
            // Обрабатываем исключение
            logErrors($th);
            return null;
        }

    }

}
