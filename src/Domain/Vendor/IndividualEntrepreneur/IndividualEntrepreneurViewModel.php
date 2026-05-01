<?php

namespace Domain\Vendor\IndividualEntrepreneur;

use App\Enum\Moonshine\PaymentNdsEnum;
use App\Models\IndividualEntrepreneur;
use Domain\Vendor\DTOs\IndividualEntrepreneurDto;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Makeable;

class IndividualEntrepreneurViewModel
{
    use Makeable;

    public function create($request): ?Model
    {
        $surname    = trim($request->surname ?? '');
        $username   = trim($request->username ?? '');
        $patronymic = trim($request->patronymic ?? '');

        $nameInitials = mb_strtoupper(mb_substr($username, 0, 1)) . '.';
        if ($patronymic !== '') {
            $nameInitials .= ' ' . mb_strtoupper(mb_substr($patronymic, 0, 1)) . '.';
        }

        $request->merge([
            'name'      => trim('ИП ' . $surname . ' ' . $nameInitials),
            'full_name' => trim('Индивидуальный предприниматель ' . $surname . ' ' . $username . ($patronymic !== '' ? ' ' . $patronymic : '')),
        ]);

        $data = IndividualEntrepreneurDto::formRequest($request);
        return IndividualEntrepreneur::create($data->toArray());
    }

    public function render($model): ?array
    {

        try {
            $data = IndividualEntrepreneurDto::model($model);

            return [
                config('site.constants.name') => $data->name,
                config('site.constants.full_name') => $data->full_name,
                config('site.constants.register_address') => $data->register_address,
                config('site.constants.address') => $data->address,
                config('site.constants.ogrnip') => $data->ogrnip,
                config('site.constants.bank') => $data->bank,
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
