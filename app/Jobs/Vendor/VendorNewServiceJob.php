<?php

namespace App\Jobs\Vendor;

use App\Mail\Vendor\VendorNewServiceMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Support\Traits\EmailAddressCollector;

class VendorNewServiceJob implements ShouldQueue
{
    use Queueable, EmailAddressCollector;

    public function __construct(public readonly array $data)
    {
    }

    public function handle(): void
    {
        Mail::to($this->emails())->send(new VendorNewServiceMail($this->data));
    }
}
