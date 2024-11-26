<?php

namespace App\Core\Objective\Infrastructure\Provider;

use Illuminate\Support\ServiceProvider;

class ObjectiveServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrations();
    }

    private function loadMigrations(): void
    {
        $this->loadMigrationsFrom(base_path('app/Core/Objective/Infrastructure/database/migrations'));

    }
}
