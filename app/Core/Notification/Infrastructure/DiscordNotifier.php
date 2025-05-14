<?php

namespace App\Core\Notification\Infrastructure;

use App\Core\Notification\Domain\Notifier;
use App\Core\Notification\Infrastructure\Dto\SendNotificationDto;

class DiscordNotifier implements Notifier
{
    public function send(SendNotificationDto $dto): void
    {
        // TODO implements Discord
    }
}
