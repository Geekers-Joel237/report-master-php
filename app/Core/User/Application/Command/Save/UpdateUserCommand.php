<?php

namespace App\Core\User\Application\Command\Save;

readonly class UpdateUserCommand
{
    public function __construct(
        public string $userId,
        public string $name,
        public string $email,
    ) {}
}