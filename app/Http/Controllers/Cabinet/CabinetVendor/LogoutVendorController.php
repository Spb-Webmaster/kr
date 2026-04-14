<?php

namespace App\Http\Controllers\Cabinet\CabinetVendor;

use App\Http\Controllers\Controller;

class LogoutVendorController extends Controller
{

    public function vendorLogout()
    {

        if (session()->exists('v')) {
            /** удалим сесиию ***/
            session()->forget('v');
            flash()->info(config('message_flash.info.__good_exit'));
            return redirect(route('vendor_login'));
        }

        flash()->alert(config('message_flash.alert.role_error'));
        return redirect(route('vendor_login'));

    }

}
