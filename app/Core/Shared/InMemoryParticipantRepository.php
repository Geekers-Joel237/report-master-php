<?php

namespace App\Core\Shared;

use App\Core\User\Domain\Entities\User;
use App\Core\User\Domain\Snapshot\UserSnapshot;
use App\Core\User\Domain\WriteUserRepository;

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
}
