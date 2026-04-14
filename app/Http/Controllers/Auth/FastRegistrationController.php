<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\FastRegistrationFormRequest;
use Domain\User\ViewModels\UserViewModel;
use Illuminate\Http\JsonResponse;

class FastRegistrationController extends Controller
{
    public function handle(FastRegistrationFormRequest $request): JsonResponse
    {
        $user = UserViewModel::make()->UserCreate(
            $request->only(['username', 'email', 'password'])
        );

        auth()->login($user, true);

        return response()->json([
            'response' => [
                'submit_form' => '.product_single__form',
            ],
        ]);
    }
}
