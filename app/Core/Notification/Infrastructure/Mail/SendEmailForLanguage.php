<?php

namespace App\Core\Notification\Infrastructure\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class SendEmailForLanguage extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
    ) {}

    public function content(): Content
    {
        return new Content(
            view: 'Mail::send_report_reminder',
        );
    }
}
