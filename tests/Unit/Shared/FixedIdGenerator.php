<?php

namespace Tests\Unit\Shared;

use App\Core\Domain\Shared\IdGenerator;

class FixedIdGenerator implements IdGenerator
{

    public function generate(): string
    {
        return '001';
    }
}
