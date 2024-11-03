<?php

namespace App\Core\Shared\Infrastructure;

use App\Core\Shared\Domain\IdGenerator;
use Illuminate\Support\Str;

class LaravelIdGenerator implements IdGenerator
{
    public function generate(): string
    {
        return Str::uuid()->toString();
    }
}
