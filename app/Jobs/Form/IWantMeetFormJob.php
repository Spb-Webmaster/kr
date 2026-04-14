<?php

namespace App\Jobs\Form;

use App\Mail\Auth\SignUpFormMail;
use App\Mail\Form\IWantMeetFormMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Support\Traits\CreatorToken;
use Support\Traits\EmailAddressCollector;

class IWantMeetFormJob  implements ShouldQueue
{
    use Queueable;

    use EmailAddressCollector;
    use CreatorToken;

    public function __construct(public  array $user)
    {

    }


    public function handle(): void
    {


        Mail::to($this->emails())->send(new IWantMeetFormMail($this->user));

    }

}
