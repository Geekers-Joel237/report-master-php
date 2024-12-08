<?php

namespace App\Core\Shared\Infrastructure\Lib;

use App\Core\User\Domain\Vo\Hasher;
use Illuminate\Support\Facades\Hash;

class LaravelHasher implements Hasher
{
    public function hash(string $password): string
    {
        return Hash::make($password);
    }

    public function check(string $password, string $hashedPassword): bool
    {
        return Hash::check($password, $hashedPassword);
    }
}
