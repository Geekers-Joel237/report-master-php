<?php

namespace App\Core\User\Domain\Vo;

interface Hasher
{
    public function hash(string $password): string;

    public function check(string $password, string $hashedPassword): bool;
}
