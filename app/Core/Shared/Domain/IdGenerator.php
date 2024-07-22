<?php

namespace App\Core\Shared\Domain;

interface IdGenerator
{
    public function generate(): string;
}
