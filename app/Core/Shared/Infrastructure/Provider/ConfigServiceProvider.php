<?php

namespace App\Core\Shared\Infrastructure\Provider;

use App\Core\Shared\Domain\IdGenerator;
use App\Core\Shared\Domain\SlugHelper;
use App\Core\Shared\Infrastructure\LaravelIdGenerator;
use App\Core\Shared\Infrastructure\LaravelSlugHelper;
use App\Core\Shared\Infrastructure\Lib\EloquentPdoConnection;
use App\Core\Shared\Lib\PdoConnection;
use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrations();
        $this->app->singleton(IdGenerator::class, LaravelIdGenerator::class);
        $this->app->singleton(SlugHelper::class, LaravelSlugHelper::class);
        $this->app->singleton(PdoConnection::class, EloquentPdoConnection::class);
    }

    private function loadMigrations(): void
    {
        $this->loadMigrationsFrom(base_path('app/Core/Shared/Infrastructure/database/migrations'));
    }
}
