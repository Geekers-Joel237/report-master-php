<?php

namespace App\Core\User\Infrastructure\Repositories;

use App\Core\User\Domain\WriteUserRepository;
use App\Core\User\Infrastructure\Models\User;

class EloquentWriteUserRepository implements WriteUserRepository
{
    public function allExists(array $participantIds): array
    {
        return User::query()->whereIn('id', $participantIds)
            ->pluck('id')->toArray();
    }
}
