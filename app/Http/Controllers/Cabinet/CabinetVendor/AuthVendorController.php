<?php

namespace App\Http\Controllers\Cabinet\CabinetVendor;

use App\Enum\TypeEnum;
use App\Event\Form\IWantMeetFormEvent;
use App\Event\Vendor\VendorSignUpEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\CabinetVendor\VendorStep1Request;
use App\Http\Requests\CabinetVendor\VendorStep2Request;
use App\Http\Requests\CabinetVendor\VendorWantYouMeetRequest;
use Domain\Vendor\IndividualEntrepreneur\IndividualEntrepreneurViewModel;
use Domain\Vendor\LegalEntity\LegalEntityViewModel;
use Domain\Vendor\SelfEmployed\SelfEmployedViewModel;
use Domain\Vendor\ViewModels\VendorViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthVendorController extends Controller
{

    public function login(): View
    {
        return view('cabinet.cabinet_vendor.auth.login');

    }

    public function handelSignIn(Request $request)
    {
        /** удалим сессию ***/
        session()->forget('v_email');
        session()->forget('v_password');

        $vendor = VendorViewModel::make()->vendor($request);

        if (is_null($vendor)) {
            flash()->alert(config('message_flash.alert.__enter_error'));

            /** запустим сессию***/
            session(['v_email' => $request->email, 'v_password' => $request->password]); // запустим сессию
            return redirect(route('vendor_login'));

        } else {
            session(['v' => $request->email]); // запустим сессию
            return redirect(route('cabinet_vendor'));
        }

    }

    public function signUp(): View
    {
        return view('cabinet.cabinet_vendor.auth.sign_up');
    }

    /**
     * Переведем на следующий шаг
     */
    public function handelSignUp(VendorStep1Request $request)
    {

        $data = $request->only('username', 'email', 'password', 'type');
        /** Сохраняем данные в сессии **/
        session()->put(config('site.constants.vendor_sign_up'), $data);
        return (TypeEnum::route($request->type)) ? redirect()->route(TypeEnum::route($request->type)) : redirect()->back();

    }

    /**
     * Следующий шаг - selfEmployed самозанятый
     */
    public function selfEmployed(): View|RedirectResponse
    {

        $vendor_sign_up = session()->get(config('site.constants.vendor_sign_up'));
        if ($vendor_sign_up) {
            return view('cabinet.cabinet_vendor.auth.2.sign_up_self_employed', $vendor_sign_up);
        }
        return redirect()->route('vendor_sign_up');

    }

    /**
     * Следующий шаг - legalEntity юридическое лицо
     */
    public function legalEntity(): View|RedirectResponse
    {
        $vendor_sign_up = session()->get(config('site.constants.vendor_sign_up'));
        if ($vendor_sign_up) {
            return view('cabinet.cabinet_vendor.auth.2.sign_up_legal_entity', $vendor_sign_up);
        }
        return redirect()->route('vendor_sign_up');

    }

    /**
     * Следующий шаг - individualEntrepreneur индивидуальный предприниматель
     */
    public function individualEntrepreneur(): View|RedirectResponse
    {
        $vendor_sign_up = session()->get(config('site.constants.vendor_sign_up'));
        if ($vendor_sign_up) {
            return view('cabinet.cabinet_vendor.auth.2.sign_up_individual_entrepreneur', $vendor_sign_up);
        }
        return redirect()->route('vendor_sign_up');
    }


    /**
     * @throws \Throwable
     */
    public function handelSignUpFinal(VendorStep2Request $request)
    {

        $vendor_sign_up = session()->get(config('site.constants.vendor_sign_up'));

        \DB::beginTransaction(); // Начинаем транзакцию
        try {
            // Сохраним данные — из сессии берём только password и type,
            // остальное (username, email и др.) берётся из формы шага 2
            $vendor = VendorViewModel::make()->create([
                'password' => $vendor_sign_up['password'],
                'type'     => $vendor_sign_up['type'],
            ], $request);
            $request->merge(['vendor_id' => $vendor->id]);

            if ($vendor_sign_up['type'] == TypeEnum::LEGALENTITY->value) {
                // LEGALENTITY - сохраним юр лицо
                LegalEntityViewModel::make()->create($request);

            }

            if ($vendor_sign_up['type'] == TypeEnum::INDIVIDUALENTREPRENEUR->value) {
                // INDIVIDUALENTREPRENEUR - сохраним ИП
                IndividualEntrepreneurViewModel::make()->create($request);


            }

            if ($vendor_sign_up['type'] == TypeEnum::SELFEMPLOYED->value) {
                // SELFEMPLOYED - сохраним самозанятого
                SelfEmployedViewModel::make()->create($request);


            }
            \DB::commit(); // Подтверждение успешной транзакции

            VendorSignUpEvent::dispatch([
                'type'       => $vendor_sign_up['type'],
                'email'      => $request->email,
                'password'   => $vendor_sign_up['password'],
                'surname'    => $request->surname,
                'username'   => $request->username,
                'patronymic' => $request->patronymic,
                'phone'      => format_phone($request->phone),
                'name'       => $request->name,
                'full_name'  => $request->full_name,
            ]);

        } catch (\Throwable $th) {

            \DB::rollBack(); // Откат транзакции в случае ошибки
            // Обрабатываем исключение
            logErrors($th);
            flash()->alert(config('message_flash.alert.i_want_meet_error'));
            return redirect()->back();

        }

        // Все прошло успешно - удалим сессию
        session()->forget(config('site.constants.vendor_sign_up'));

        flash()->info(config('message_flash.info.sign_up_vendor_ok'));
        return redirect()->route('vendor_login');

        // email, type, password

    }


    /**
     * Следующий шаг - Хочу заполнить данные при встрече с представителем
     */
    public function handelIWantToMeet(VendorWantYouMeetRequest $request)
    {

        try {

            IWantMeetFormEvent::dispatch(
                [
                    'username' => $request->username,
                    'phone' => format_phone($request->phone),
                    'type' => (TypeEnum::fromValue($request->type)->toString()) ?? '-',
                    'email' => $request->email,
                ]
            );

            flash()->info(config('message_flash.info.i_want_meet_ok'));
            return redirect()->route('vendor_login');

        } catch (\Throwable $th) {

            // Обрабатываем исключение
            logErrors($th);
            flash()->alert(config('message_flash.alert.i_want_meet_error'));
            return redirect()->back();

        }

    }


}
