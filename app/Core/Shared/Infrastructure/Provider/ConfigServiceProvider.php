<?php

namespace App\Core\Shared\Infrastructure\Provider;

use App\Core\Shared\Domain\IdGenerator;
use App\Core\Shared\Infrastructure\LaravelIdGenerator;
use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrations();
        $this->app->singleton(IdGenerator::class, LaravelIdGenerator::class);
    }

    private function loadMigrations(): void
    {
        $this->loadMigrationsFrom(base_path('app/Core/Shared/Infrastructure/database/migrations'));
    }
}
