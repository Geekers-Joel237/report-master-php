<?php

namespace App\Core\Notification\Infrastructure\Dto;

readonly class SendNotificationDto
{
    public function __construct(
        public string $subject,
        public array $to,
        public string $message,
    ) {}
}
