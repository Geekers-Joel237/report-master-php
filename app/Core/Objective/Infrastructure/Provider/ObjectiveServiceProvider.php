<?php

namespace App\Core\Objective\Infrastructure\Provider;

use App\Core\Objective\Domain\Repository\ReadObjectiveRepository;
use App\Core\Objective\Domain\Repository\WriteObjectiveRepository;
use App\Core\Objective\Infrastructure\Repository\EloquentReadObjectiveRepository;
use App\Core\Objective\Infrastructure\Repository\EloquentWriteObjectiveRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ObjectiveServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrations();
        $this->registerRoutes();
        $this->bindRepositories();

    }

    private function loadMigrations(): void
    {
        $this->loadMigrationsFrom(base_path('app/Core/Objective/Infrastructure/database/migrations'));

    }

    private function registerRoutes(): void
    {
        Route::group($this->routeConfig(), function () {
            $this->loadRoutesFrom(base_path('app/Core/Objective/Infrastructure/routes/api.php'));
        });
    }

    private function routeConfig(): array
    {
        return [
            'prefix' => 'api/v1',
            'middleware' => ['api', 'auth:sanctum'],
        ];
    }

    private function bindRepositories(): void
    {
        $this->app->singleton(WriteObjectiveRepository::class, EloquentWriteObjectiveRepository::class);
        $this->app->singleton(ReadObjectiveRepository::class, EloquentReadObjectiveRepository::class);
    }
}
