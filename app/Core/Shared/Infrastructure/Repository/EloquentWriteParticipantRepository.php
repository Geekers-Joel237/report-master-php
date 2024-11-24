<?php

namespace App\Core\Shared\Infrastructure\Repository;

use App\Core\User\Domain\WriteUserRepository;
use App\Core\User\Infrastructure\Models\User;

class EloquentWriteParticipantRepository implements WriteUserRepository
{
    public function allExists(array $participantIds): array
    {
        return User::query()->whereIn('id', $participantIds)
            ->pluck('id')->toArray();
    }
}
