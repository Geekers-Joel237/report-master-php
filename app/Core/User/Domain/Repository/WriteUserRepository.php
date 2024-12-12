<?php

namespace App\Core\User\Domain\Repository;

use App\Core\User\Domain\Entities\User;
use App\Core\User\Domain\Snapshot\UserSnapshot;

interface WriteUserRepository
{
    /**
     * @param  string[]  $participantIds
     * @return string[]
     */
    public function allExists(array $participantIds): array;

    public function emailExists(string $email, ?string $userId): bool;

    public function save(UserSnapshot $user): void;

    public function ofId(?string $userId): ?User;

    public function update(UserSnapshot $user): void;

    public function exists(string $userId): bool;

    public function delete(string $userId): void;
}
