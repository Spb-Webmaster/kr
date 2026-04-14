<?php

namespace App\Http\Controllers\Cabinet\CabinetVendor;

use App\Http\Controllers\Controller;

use Domain\Vendor\ViewModels\VendorViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;


class CabinetVendorController extends Controller
{

    public function cabinetVendor():View
    {
        $vendor = VendorViewModel::make()->v(session()->get('v'));
         return view('cabinet.cabinet_vendor.cabinet_vendor', compact('vendor'));
    }

    /** Список услуг */
    public function cabinetVendorServices():View
    {
        $vendor = VendorViewModel::make()->v(session()->get('v'));
        return view('cabinet.cabinet_vendor.services.services', compact('vendor'));
    }

    /** Добавить услугу */
    public function cabinetVendorServiceAdd():View
    {
        $vendor = VendorViewModel::make()->v(session()->get('v'));
        return view('cabinet.cabinet_vendor.services.partial.add', compact('vendor'));
    }

}
