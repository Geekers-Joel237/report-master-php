<?php

namespace App\Core\Notification\Infrastructure;

use App\Core\Notification\Domain\Notifier;
use App\Core\Notification\Infrastructure\Dto\SendNotificationDto;

class SlackNotifier implements Notifier
{
    public function send(SendNotificationDto $dto): void
    {
        // TODO: Slack notification
    }
}
