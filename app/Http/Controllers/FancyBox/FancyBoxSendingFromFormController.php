<?php

namespace App\Http\Controllers\FancyBox;

use App\Events\Form\FancyBoxSelectTarifEvent;
use App\Events\Form\FancyBoxSendingFromFormEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequestCallMeBlueRequest;
use App\Http\Requests\RequestCallMeRequest;
use App\Http\Requests\RequestConsultMeRequest;
use App\Http\Requests\RequestForTrainingRequest;
use App\Http\Requests\SendSubscriptionMeRequest;
use Domain\SavedFormData\ViewModel\SavedFormDataViewModel;
use Domain\User\ViewModels\UserViewModel;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;


class FancyBoxSendingFromFormController extends Controller
{
    /** подписаться  */
    public function fancyboxSubscriptionMe(SendSubscriptionMeRequest $request) {

      SavedFormDataViewModel::make()->save($request);
        $data = $request->except('url');
        FancyBoxSendingFromFormEvent::dispatch($data);

     return response()->json([
            'response' => $request->all(),
        ], 200);

    }

}
