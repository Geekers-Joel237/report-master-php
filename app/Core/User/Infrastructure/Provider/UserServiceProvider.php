<?php

namespace App\Core\User\Infrastructure\Provider;

use App\Core\User\Domain\WriteUserRepository;
use App\Core\User\Infrastructure\Repositories\EloquentWriteUserRepository;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrations();
        $this->bindRepositories();
    }

    private function loadMigrations(): void
    {
        $this->loadMigrationsFrom(base_path('app/Core/User/Infrastructure/database/migrations'));
    }

    private function bindRepositories(): void
    {
        $this->app->singleton(WriteUserRepository::class, EloquentWriteUserRepository::class);
    }
}
