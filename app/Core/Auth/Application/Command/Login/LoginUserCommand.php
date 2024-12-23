<?php

namespace App\Core\Auth\Application\Command\Login;

readonly class LoginUserCommand
{
    public function __construct(
        public string $email,
        public string $password
    ) {}
}
