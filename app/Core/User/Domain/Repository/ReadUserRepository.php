<?php

namespace App\Core\User\Domain\Repository;

use App\Core\User\Domain\Dto\UserProfileDto;

interface ReadUserRepository
{
    public function profile(string $userId): ?UserProfileDto;
}
