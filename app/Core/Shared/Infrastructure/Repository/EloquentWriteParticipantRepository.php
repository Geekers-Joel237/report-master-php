<?php

namespace App\Core\Shared\Infrastructure\Repository;

use App\Core\User\Domain\Snapshot\UserSnapshot;
use App\Core\User\Domain\WriteUserRepository;
use App\Core\User\Infrastructure\Models\User;

class EloquentWriteParticipantRepository implements WriteUserRepository
{
    public function allExists(array $participantIds): array
    {
        return User::query()->whereIn('id', $participantIds)
            ->pluck('id')->toArray();
    }

    public function emailExists(string $email, ?string $userId): bool
    {
        return User::query()
            ->where('email', $email)
            ->when($userId, fn ($q) => $q->where('id', '!=', $userId))
            ->exists();
    }

    public function save(UserSnapshot $user): void
    {
        User::query()->create($user->toArray());
    }

    public function ofId(?string $userId): ?\App\Core\User\Domain\Entities\User
    {
        return User::query()->find($userId)?->toDomain();
    }

    public function update(UserSnapshot $snapshot): void
    {
        User::query()->update($snapshot->toArray());
    }
}
