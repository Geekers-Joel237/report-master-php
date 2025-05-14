<?php

namespace App\Core\Notification\Infrastructure;

use App\Core\Notification\Domain\Notifier;
use App\Core\Notification\Infrastructure\Dto\SendNotificationDto;
use App\Core\Notification\Infrastructure\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;

class MailNotifier implements Notifier
{
    public function send(SendNotificationDto $dto): void
    {
        Mail::to($dto->to)->queue(new SendEmail($dto));
    }
}
