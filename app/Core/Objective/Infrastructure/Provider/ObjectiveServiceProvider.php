<?php

namespace App\Core\Objective\Infrastructure\Provider;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ObjectiveServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrations();
        $this->registerRoutes();

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
        ];
    }
}
