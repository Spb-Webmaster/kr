<?php

namespace App\Listeners\Order;

use App\Event\Order\SendCertificateEvent;
use App\Jobs\Order\SendCertificateJob;

class SendCertificateHandlerListener
{
    public function handle(SendCertificateEvent $event): void
    {
        SendCertificateJob::dispatch($event->orderNumber, $event->email);
    }
}
