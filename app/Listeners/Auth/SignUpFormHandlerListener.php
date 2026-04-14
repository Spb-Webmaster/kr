<?php

namespace App\Listeners\Auth;

use App\Event\Auth\SignUpFormEvent;
use App\Jobs\Auth\SignUpFormJob;
use Support\Traits\CreatorToken;
use Support\Traits\EmailAddressCollector;

class SignUpFormHandlerListener
{
    use EmailAddressCollector;
    use CreatorToken;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     * сообщение
     */
    public function handle(SignUpFormEvent $event): void
    {
        SignUpFormJob::dispatch($event->user); // Job

    }
}
