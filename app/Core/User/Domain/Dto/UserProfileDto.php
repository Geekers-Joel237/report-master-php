<?php

namespace App\Core\User\Domain\Dto;

readonly class UserProfileDto
{
    public string $userId;

    public string $name;

    public string $email;

    public string $roleId;

    public string $roleName;
}
