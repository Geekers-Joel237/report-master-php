<?php

namespace App\Core\Project\Infrastructure\Provider;

use App\Core\Project\Domain\Repositories\ReadProjectRepository;
use App\Core\Project\Infrastructure\Repositories\EloquentReadProjectRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ProjectServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrations();
        $this->registerRoutes();
        $this->registerRepositories();
    }

    public function loadMigrations(): void
    {
        $this->loadMigrationsFrom(base_path('app/Core/Project/Infrastructure/database/migrations'));
    }

    private function registerRepositories(): void
    {
        $this->app->singleton(ReadProjectRepository::class, EloquentReadProjectRepository::class);
    }

    private function registerRoutes(): void
    {
        Route::group($this->routeConfig(), function () {
            $this->loadRoutesFrom(base_path('app/Core/Project/Infrastructure/routes/api.php'));
        });
    }

    private function routeConfig(): array
    {
        return [
            'prefix' => 'api/v1',
        ];
    }
}
