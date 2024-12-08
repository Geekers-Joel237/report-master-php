<?php

namespace App\Core\Shared;

use App\Core\User\Domain\Entities\User;
use App\Core\User\Domain\Snapshot\UserSnapshot;
use App\Core\User\Domain\WriteUserRepository;

class InMemoryParticipantRepository implements WriteUserRepository
{
    public array $participantIds = [];

    public function __construct() {}

    public function allExists(array $participantIds): array
    {
        return array_intersect($participantIds, $this->participantIds);
    }

    public function emailExists(string $email, ?string $userId): bool
    {
        // TODO: Implement emailExists() method.
    }

    public function save(UserSnapshot $user): void
    {
        // TODO: Implement save() method.
    }

    public function ofId(?string $userId): ?User
    {
        // TODO: Implement ofId() method.
    }

    public function update(UserSnapshot $snapshot): void
    {
        // TODO: Implement update() method.
    }
}
