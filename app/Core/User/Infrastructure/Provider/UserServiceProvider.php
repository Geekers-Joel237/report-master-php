<?php

namespace App\Core\User\Infrastructure\Provider;

use App\Core\Shared\Infrastructure\Repository\EloquentWriteParticipantRepository;
use App\Core\User\Domain\WriteUserRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerRoutes();
        $this->loadMigrations();
        $this->bindRepositories();
    }

    private function loadMigrations(): void
    {
        $this->loadMigrationsFrom(base_path('app/Core/User/Infrastructure/database/migrations'));
    }

    private function bindRepositories(): void
    {
        $this->app->singleton(WriteUserRepository::class, EloquentWriteParticipantRepository::class);
    }

    private function registerRoutes(): void
    {
        Route::group($this->routeConfig(), function () {
            $this->loadRoutesFrom(base_path('app/Core/User/Infrastructure/routes/api.php'));
        });
    }

    /**
     * @return string[]
     */
    private function routeConfig(): array
    {
        return [
            'prefix' => 'api/v1',
        ];
    }
}
