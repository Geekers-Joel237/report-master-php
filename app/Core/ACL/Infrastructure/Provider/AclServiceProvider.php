<?php

namespace App\Core\ACL\Infrastructure\Provider;

use Illuminate\Support\ServiceProvider;

class AclServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrations();
    }

    private function loadMigrations(): void
    {
        $this->loadMigrationsFrom(base_path('app/Core/ACL/Infrastructure/database/migrations'));

    }
}
