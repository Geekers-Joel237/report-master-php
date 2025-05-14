<?php

namespace App\Core\Notification\Infrastructure\Mail;

use App\Core\Notification\Infrastructure\Dto\SendNotificationDto;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly SendNotificationDto $dto
    ) {}

    public function content(): Content
    {
        return new Content(
            view: 'Mail::send_reminder',
            with: ['dto' => $this->dto]
        );
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->dto->subject
        );
    }
}
