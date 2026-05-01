<?php

namespace App\Mail\Vendor;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VendorNewServiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly array $data)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'АДМИНУ | Новая услуга поставщика — требует проверки');
    }

    public function content(): Content
    {
        return new Content(
            view: 'html.email.vendor.new_service',
            with: ['data' => $this->data],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
