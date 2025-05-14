<?php

namespace App\Core\Notification\Domain;

use App\Core\Notification\Infrastructure\Dto\SendNotificationDto;

interface Notifier
{
    public function send(SendNotificationDto $dto): void;
}
