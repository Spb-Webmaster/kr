<?php

namespace App\Http\Controllers\Auth;

use App\Event\Auth\ForgotPasswordEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordFormRequest;
use App\Models\User;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;


class ForgotPasswordController extends Controller
{
    public function page()
    {
        $forgot = false;
        if(session('forgot')) {
            $forgot = true;
            session()->forget('forgot');
        }

        return view('auth.forgot-password', [ 'forgot' => $forgot]);
    }


    public function handle(ForgotPasswordFormRequest $request):RedirectResponse
    {

        $broker = app(PasswordBrokerManager::class)->broker();
        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
           // flash()->alert(config('message_flash.alert.user_not_found'));
            return back()->withErrors(['email' => config('message_flash.alert.user_not_found')]);
        }

       // Генерируем токен
        $token = $broker->createToken($user);
        Log::alert($token);


        // Отправляем письмо с использованием касторного подхода
        ForgotPasswordEvent::dispatch(
            [
                'email' => $user->email,
                'token' => $token,
            ]
        );

        flash()->info(config('message_flash.info.password_reset_link_sent'));

        session(['forgot' => 1]);
        return redirect()->route('forgot');
    }


}
