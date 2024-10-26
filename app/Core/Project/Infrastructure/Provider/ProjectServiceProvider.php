<?php

namespace App\Core\Project\Infrastructure\Provider;

use Illuminate\Support\ServiceProvider;

class ProjectServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrationsFrom(base_path('app/Core/Project/Infrastructure/database/migrations'));
    }
}
