<?php

namespace App\Core\User\Application\Command\Save;

readonly class SaveUserCommand
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public string $role
    ) {}
}
