<?php

namespace App\Jobs\Vendor;

use App\Enum\TypeEnum;
use App\Mail\Vendor\VendorSignUpAdminMail;
use App\Mail\Vendor\VendorSignUpIndividualEntrepreneurMail;
use App\Mail\Vendor\VendorSignUpLegalEntityMail;
use App\Mail\Vendor\VendorSignUpSelfEmployedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Support\Traits\EmailAddressCollector;

class VendorSignUpJob implements ShouldQueue
{
    use Queueable, EmailAddressCollector;

    public function __construct(public readonly array $vendor)
    {
    }

    public function handle(): void
    {
        $mail = match ($this->vendor['type']) {
            TypeEnum::LEGALENTITY->value            => new VendorSignUpLegalEntityMail($this->vendor),
            TypeEnum::INDIVIDUALENTREPRENEUR->value => new VendorSignUpIndividualEntrepreneurMail($this->vendor),
            default                                 => new VendorSignUpSelfEmployedMail($this->vendor),
        };

       Mail::to($this->vendor['email'])->send($mail);
       Mail::to($this->emails())->send(new VendorSignUpAdminMail($this->vendor));
    }
}
