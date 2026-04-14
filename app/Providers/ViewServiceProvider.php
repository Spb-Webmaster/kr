<?php

namespace App\Providers;

use App\View\Composers\VendorSignUpComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        View::composer([
            'cabinet.cabinet_vendor.auth.sign_up',
            'cabinet.cabinet_vendor.auth.2.sign_up_individual_entrepreneur',
            'cabinet.cabinet_vendor.auth.2.sign_up_legal_entity',
            'cabinet.cabinet_vendor.auth.2.sign_up_self_employed'
        ], VendorSignUpComposer::class);




    }
}
