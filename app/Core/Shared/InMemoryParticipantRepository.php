<?php

namespace App\Core\Shared;

use App\Core\ACL\Infrastructure\Models\ModelHasRole;
use App\Core\User\Domain\Entities\User;
use App\Core\User\Domain\Repository\WriteUserRepository;
use App\Core\User\Domain\Snapshot\UserSnapshot;

class InMemoryParticipantRepository implements WriteUserRepository
{
    public array $participantIds = [];

    private array $users = [];

    public function __construct() {}

    public function allExists(array $participantIds): array
    {
        return array_intersect($participantIds, $this->participantIds);
    }

    public function emailExists(string $email, ?string $userId): bool
    {
        return false;
    }

    public function save(UserSnapshot $user): void
    {
        $this->users[$user->id] = $user;
    }

    public function ofId(?string $userId): ?User
    {
        return array_key_exists($userId, $this->users) ? $this->users[$userId] : null;
    }

    public function update(UserSnapshot $user): void
    {
        $this->users[$user->id] = $user;

    }

    public function exists(string $userId): bool
    {
        return User::query()->find($userId);
    }

    public function delete(string $userId): void
    {
        $user = \App\Core\User\Infrastructure\Models\User::query()->findOrFail($userId);

        $user->update(['is_deleted' => 1]);

        $userhasdelete= ModelHasRole::query()->findOrFail($userId);

        $userhasdelete->delete();

    }
}
