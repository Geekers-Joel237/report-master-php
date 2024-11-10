<?php

namespace App\Core\User\Infrastructure\Repositories;

use App\Core\User\Domain\WriteUserRepository;

class EloquentWriteUserRepository implements WriteUserRepository
{
    public function allExists(array $participantIds): array
    {
        // TODO: Implement allExists() method.
    }
}
