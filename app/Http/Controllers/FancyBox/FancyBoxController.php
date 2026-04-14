<?php

namespace App\Http\Controllers\FancyBox;

use App\Http\Controllers\Controller;
use App\Models\User;
use Domain\User\ViewModels\UserViewModel;
use Illuminate\Http\Request;

class FancyBoxController extends Controller
{
    public function fancybox(Request $request) {



        if($request->template == 'i_want_to_meet_you') {
            $vendor_sign_up = session()->get(config('site.constants.vendor_sign_up'));


            $type = (isset($vendor_sign_up['type'])) ? $vendor_sign_up['type'] : '';
            $username = (isset($vendor_sign_up['username'])) ? $vendor_sign_up['username'] : '';
            $email = (isset($vendor_sign_up['email'])) ? $vendor_sign_up['email'] : '';
            return view('fancybox.forms.i_want_to_meet_you', compact('email','username', 'type'));
        }


        if($request->template == 'fast_registration') {

            $redirectTo = '';
            if ($request->data) {
                $decoded = json_decode($request->data, true);
                $redirectTo = $decoded['redirect'] ?? '';
            }

            return view('fancybox.forms.fast_registration', compact('redirectTo'));

        }


        if ($request->template == 'fast_login') {
            return view('fancybox.forms.fast_login');
        }

        if ($request->template == 'no_registration') {

            $redirectTo = '';
            if ($request->data) {
                $decoded = json_decode($request->data, true);
                $redirectTo = $decoded['redirect'] ?? '';
            }

            return view('fancybox.forms.no_registration', compact('redirectTo'));

        }

        return view('fancybox.forms.error.error_form');

    }

}
