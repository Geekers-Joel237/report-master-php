<?php

namespace App\Core\User\Domain\Snapshot;

readonly class UserSnapshot
{
    /**
     * @param  array|string[]  $roles
     */
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public string $password,
        public array $roles,
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
