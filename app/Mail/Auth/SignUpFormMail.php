<?php

namespace App\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SignUpFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $formattedData;

    /**
     * Create a new message instance.
     *
     * @param array $user Исходные данные из формы
     */
    public function __construct(array $user)
    {
        $this->formattedData = $this->formatDataForView($user);
    }

    protected function formatDataForView(array $user): array
    {
        return $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Регистрация на сайте'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(view: 'html.email.i_want_meet', with: ['user' => $this->formattedData]);

    }


    public function attachments(): array
    {
        return [];
    }
}
