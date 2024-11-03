<?php

namespace App\Core\Shared\Domain;

interface SlugHelper
{
    public function slugify(string $value): string;
}
