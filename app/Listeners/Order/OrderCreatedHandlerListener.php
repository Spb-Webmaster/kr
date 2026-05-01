<?php

namespace App\Listeners\Order;

use App\Event\Order\OrderCreatedEvent;
use App\Jobs\Order\OrderCreatedJob;

class OrderCreatedHandlerListener
{
    public function handle(OrderCreatedEvent $event): void
    {
        OrderCreatedJob::dispatch($event->data);
    }
}
