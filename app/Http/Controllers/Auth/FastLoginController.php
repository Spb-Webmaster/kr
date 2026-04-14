<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\FastLoginFormRequest;
use Illuminate\Http\JsonResponse;

class FastLoginController extends Controller
{
    public function handle(FastLoginFormRequest $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);

        if (!auth()->attempt($credentials, true)) {
            return response()->json([
                'errors' => [
                    'email' => ['Неверный e-mail или пароль'],
                ],
            ]);
        }

        return response()->json([
            'response' => [
                'submit_form' => '.product_single__form',
            ],
        ]);
    }
}
