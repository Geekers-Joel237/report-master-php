<?php

namespace App\Core\Auth\Infrastructure\Provider;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerRoutes();

    }

    private function registerRoutes(): void
    {
        Route::group($this->routeConfig(), function () {
            $this->loadRoutesFrom(base_path('app/Core/Auth/Infrastructure/routes/api.php'));
        });
    }

    private function routeConfig(): array
    {
        return [
            'prefix' => 'api/v1',
        ];
    }
}
