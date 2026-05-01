<?php

namespace App\Listeners\Vendor;

use App\Event\Vendor\VendorSignUpEvent;
use App\Jobs\Vendor\VendorSignUpJob;

class VendorSignUpHandlerListener
{
    public function handle(VendorSignUpEvent $event): void
    {
        VendorSignUpJob::dispatch($event->vendor);
    }
}
