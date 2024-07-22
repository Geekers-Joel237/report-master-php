<?php

namespace App\Core\Domain\Shared;

interface IdGenerator
{
    public function generate(): string;
}
