<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoRegistrationFormRequest;
use Illuminate\Http\JsonResponse;

class NoRegistrationController extends Controller
{
    public function handle(NoRegistrationFormRequest $request): JsonResponse
    {
        $validated = $request->only(['username', 'email', 'phone']);

        session(['guest_order_user' => $validated]);

        return response()->json([
            'response' => [
                'submit_form' => '.product_single__form',
            ],
        ]);
    }
}
