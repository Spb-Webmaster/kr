<?php

namespace App\Listeners\Auth;

use App\Event\Auth\ForgotPasswordEvent;
use App\Mail\Auth\ForgotPasswordMail;
use Illuminate\Support\Facades\Mail;
use Support\Traits\CreatorToken;
use Support\Traits\EmailAddressCollector;

class ForgotPasswordHandlerListener
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
    public function handle(ForgotPasswordEvent $event): void
    {
        Mail::to($event->user['email'])->send(new ForgotPasswordMail($event->user));

    }
}
