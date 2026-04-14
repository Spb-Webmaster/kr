<?php

namespace App\Jobs\Auth;

use App\Mail\Auth\SignUpFormMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Support\Traits\CreatorToken;
use Support\Traits\EmailAddressCollector;

class SignUpFormJob  implements ShouldQueue
{
    use Queueable;

    use EmailAddressCollector;
    use CreatorToken;

    public function __construct(public  array $user)
    {

    }


    public function handle(): void
    {
        Mail::to($this->user['email'])->send(new SignUpFormMail($this->user));

    }

}
