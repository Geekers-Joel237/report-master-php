<?php

namespace App\Core\User\Domain\Entities;

use App\Core\User\Domain\Exceptions\NotEmptyException;
use App\Core\User\Domain\Snapshot\UserSnapshot;
use App\Core\User\Domain\Vo\Hasher;
use App\Core\User\Domain\Vo\Password;

class User
{
    private function __construct(
        private readonly string $id,
        private string $name,
        private string $email,
        private readonly Password $password,
    ) {}

    public static function create(
        string $name,
        string $email,
        string $password,
        string $userId,
        Hasher $hasher
    ): self {
        return new self(
            id: $userId,
            name: $name,
            email: $email,
            password: new Password($password, $hasher)
        );
    }

    public static function createFromAdapter(
        string $id,
        string $name,
        string $email,
        string $password
    ) {
        return new self(
            id: $id,
            name: $name,
            email: $email,
            password: Password::fromAdapter($password)
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
