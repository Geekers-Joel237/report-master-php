<?php

namespace App\Core\Auth\Infrastructure\ViewModels;

class AuthUserViewModel
{
    public function __construct(
        public string $userId,

        public string $name,

        public string $email,

        public string $roleId,

        public string $roleName,
        public string $token,
    ) {}
}
