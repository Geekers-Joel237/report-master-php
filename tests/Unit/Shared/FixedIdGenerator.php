<?php

namespace Tests\Shared\Unit;

use App\Core\Shared\Domain\IdGenerator;

class FixedIdGenerator implements IdGenerator
{

    public function generate(): string
    {
        return '001';
    }
}
