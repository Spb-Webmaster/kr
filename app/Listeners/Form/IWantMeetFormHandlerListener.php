<?php

namespace App\Listeners\Form;

use App\Event\Form\IWantMeetFormEvent;
use App\Jobs\Form\IWantMeetFormJob;
use Support\Traits\CreatorToken;
use Support\Traits\EmailAddressCollector;

class IWantMeetFormHandlerListener
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
    public function handle(IWantMeetFormEvent $event): void
    {
        IWantMeetFormJob::dispatch($event->user); // Job

    }
}
