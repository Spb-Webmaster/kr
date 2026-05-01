<?php

namespace App\Listeners\Vendor;

use App\Event\Vendor\VendorNewServiceEvent;
use App\Jobs\Vendor\VendorNewServiceJob;

class VendorNewServiceHandlerListener
{
    public function handle(VendorNewServiceEvent $event): void
    {
        VendorNewServiceJob::dispatch($event->data);
    }
}
