<?php

namespace App\Core\Notification\Infrastructure\Mail;

use App\Core\Notification\Infrastructure\Dto\SendEmailForLanguageDto;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class SendEmailForLanguage extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public SendEmailForLanguageDto $dto
    ) {}

    public function content(): Content
    {
        return new Content(
            view: 'Mail::send_report_reminder',
        );
    }
}
