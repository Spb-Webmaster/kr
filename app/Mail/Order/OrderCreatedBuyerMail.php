<?php

namespace App\Mail\Order;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderCreatedBuyerMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly array $data)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Ваш заказ № ' . $this->data['order_number'] . ' — ' . $this->data['title']);
    }

    public function content(): Content
    {
        return new Content(
            view: 'html.email.order.created_buyer',
            with: ['data' => $this->data],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
