<?php

namespace App\Core\User\Infrastructure\Provider;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrations();
    }

    private function loadMigrations(): void
    {
        $this->loadMigrationsFrom(base_path('app/Core/User/Infrastructure/database/migrations'));
    }
}
