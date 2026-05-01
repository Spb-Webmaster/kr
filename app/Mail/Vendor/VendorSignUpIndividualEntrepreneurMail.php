<?php

namespace App\Mail\Vendor;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VendorSignUpIndividualEntrepreneurMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly array $vendor)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Регистрация поставщика услуг');
    }

    public function content(): Content
    {
        return new Content(
            view: 'html.email.vendor.sign_up_individual_entrepreneur',
            with: ['vendor' => $this->vendor],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
