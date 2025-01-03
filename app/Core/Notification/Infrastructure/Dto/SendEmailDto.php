<?php

namespace App\Core\Notification\Infrastructure\Dto;

readonly class SendEmailDto
{
    public function __construct(
        public string $object,
        public string $recipient,
        public string $recipientName
    ) {}
}
