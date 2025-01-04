<?php

namespace App\Core\Notification\Infrastructure\Dto;

readonly class SendEmailForLanguageDto
{
    public function __construct(
        public string $object,
        public string $recipient,
        public string $recipientName,
        public string $message
    ) {}
}
