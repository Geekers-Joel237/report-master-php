<?php

namespace App\Core\Shared\Infrastructure;

use App\Core\Shared\Domain\SlugHelper;
use Illuminate\Support\Str;

class LaravelSlugHelper implements SlugHelper
{

    public function slugify(string $value): string
    {
        return Str::slug($value);
    }
}
