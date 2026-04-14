<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordFormRequest;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ResetPasswordController extends Controller
{

    public function page(Request $request, string $token): View|RedirectResponse
    {
        // Получаем email из запроса
        $email = $request->query('email');

        // Если email не передан, запрашиваем его
        if (!$email) {
            flash()->alert(config('message_flash.alert.password_reset_no_email'));
            return redirect()->route('forgot');
        }

        // Валидируем email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            flash()->alert(config('message_flash.alert.password_reset_no_correct_email'));
            return redirect()->route('forgot');
        }

        // Проверяем существование пользователя
        $user = User::where('email', $email)->first();

        if (!$user) {
            flash()->alert(config('message_flash.alert.password_reset_no_user'));
            return redirect()->route('forgot');
        }

        // Проверяем токен с помощью Password Broker
        $broker = Password::broker();

        // Получаем пользователя по email
        $user = $broker->getUser(['email' => $email]);

        if (!$user) {
           // flash()->error('Пользователь с таким email не найден.');
            return redirect()->route('forgot');
        }

        // Проверяем существование токена для пользователя
        if (!$broker->tokenExists($user, $token)) {
            flash()->alert(config('message_flash.alert.password_reset_error'));
            return redirect()->route('forgot');
        }

        // Токен действителен, показываем форму
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email
        ]);
    }


    /**
     * Обработка формы сброса пароля
     */
    public function handle(ResetPasswordFormRequest $request): RedirectResponse
    {

        // Используем стандартный механизм сброса пароля Laravel
        $status = Password::reset(
            [
                'email' => $request['email'],
                'password' => $request['password'],
                'password_confirmation' => $request['password_confirmation'],
                'token' => $request['token']
            ],

            function ($user, $password) {
                // Обновляем пароль
                $user->password = Hash::make($password);

                // Сбрасываем remember token для безопасности
                $user->setRememberToken(Str::random(60));

                // Сохраняем изменения
                $user->save();

                // Вызываем событие сброса пароля
                event(new PasswordReset($user));

                // Можно также очистить все активные сессии пользователя
                // $user->tokens()->delete(); // Если используете API токены
            }
        );

        // Обрабатываем результат
        if ($status === Password::PASSWORD_RESET) {
            flash()->info(config('message_flash.info.password_reset_ok'));
            return redirect()->route('login');
        }

        // Если произошла ошибка
        $errors = [];

        switch ($status) {
            case Password::INVALID_TOKEN:
                $errors['token'] = 'Недействительный токен сброса пароля.';
                break;
            case Password::INVALID_USER:
                $errors['email'] = 'Пользователь с таким email не найден.';
                break;
            case Password::RESET_THROTTLED:
                $errors['email'] = 'Слишком много попыток сброса пароля. Пожалуйста, попробуйте позже.';
                break;
            default:
                $errors['email'] = 'Произошла ошибка при сбросе пароля.';
                break;
        }

        return back()->withErrors($errors);
    }


}
