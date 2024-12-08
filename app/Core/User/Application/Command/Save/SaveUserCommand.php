<?php

namespace App\Core\User\Application\Command\Save;

class SaveUserCommand
{
    public ?string $userId = null;

    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password
    ) {}
}
