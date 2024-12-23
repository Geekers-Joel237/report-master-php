<?php

namespace App\Core\Shared\Infrastructure\Repository;

use App\Core\ACL\Infrastructure\Models\ModelHasRole;
use App\Core\ACL\Infrastructure\Models\Role;
use App\Core\User\Domain\Exceptions\ErrorOnSaveUserException;
use App\Core\User\Domain\Repository\WriteUserRepository;
use App\Core\User\Domain\Snapshot\UserSnapshot;
use App\Core\User\Infrastructure\Models\User;
use Throwable;

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
        try {
            $eUser = User::query()->create($user->toArray());
            $eUser->roles()->sync(Role::query()->whereIn('name', $user->roles)->pluck('id')->toArray());

        } catch (Throwable $e) {
            throw new ErrorOnSaveUserException($e->getMessage());
        }
    }

    public function ofId(?string $userId): ?\App\Core\User\Domain\Entities\User
    {
        return User::query()->find($userId)?->toDomain();
    }

    public function update(UserSnapshot $user): void
    {
        User::query()->update($user->toArray());
    }

    public function exists(string $userId): bool
    {

        return User::query()->where('id', $userId)->exists();

    }

    public function delete(string $userId): void
    {
        ModelHasRole::query()->where('model_id', $userId)
            ->where('model_type', User::class)->delete();

        User::query()->find($userId)->softDelete();

    }
}
