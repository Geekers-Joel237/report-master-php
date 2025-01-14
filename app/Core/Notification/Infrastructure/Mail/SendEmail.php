<?php

namespace App\Core\Notification\Infrastructure\Mail;

use App\Core\Notification\Infrastructure\Dto\SendEmailDto;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public SendEmailDto $dto
    ) {}

    public function content(): Content
    {
        return new Content(
            view: 'Mail::send_report_reminder',
        );
    }
}
