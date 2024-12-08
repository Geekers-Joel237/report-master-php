<?php

namespace App\Core\User\Domain\Entities;

use App\Core\ACL\Domain\Enums\RoleEnum;
use App\Core\Shared\Domain\Exceptions\InvalidCommandException;
use App\Core\User\Domain\Exceptions\NotEmptyException;
use App\Core\User\Domain\Snapshot\UserSnapshot;
use App\Core\User\Domain\Vo\Hasher;
use App\Core\User\Domain\Vo\Password;

class User
{
    /**
     * @param  RoleEnum[]|array  $roles
     */
    private function __construct(
        private readonly string $id,
        private string $name,
        private string $email,
        private readonly Password $password,
        private readonly array $roles,
    ) {}

    public static function create(
        string $name,
        string $email,
        string $password,
        string $userId,
        Hasher $hasher,
        RoleEnum $role
    ): self {
        return new self(
            id: $userId,
            name: $name,
            email: $email,
            password: new Password($password, $hasher),
            roles: [$role]
        );
    }

    /**
     * @throws InvalidCommandException
     */
    public static function createFromAdapter(
        string $id,
        string $name,
        string $email,
        string $password,
        array $roles
    ): User {
        return new self(
            id: $id,
            name: $name,
            email: $email,
            password: Password::fromAdapter($password),
            roles: array_map(fn ($r) => RoleEnum::in($r), $roles)
        );
    }

    /**
     * @throws NotEmptyException
     */
    public function snapshot(): UserSnapshot
    {
        return new UserSnapshot(
            id: $this->id,
            name: $this->name,
            email: $this->email,
            password: $this->password->hash(),
            roles: array_map(fn ($r) => $r->value, $this->roles)
        );
    }

    public function update(string $name, string $email): User|static
    {
        $clone = clone $this;
        $clone->name = $name;
        $clone->email = $email;

        return $clone;
    }
}
