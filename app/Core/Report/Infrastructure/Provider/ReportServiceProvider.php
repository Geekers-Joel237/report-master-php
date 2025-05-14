<?php

namespace App\Core\Report\Infrastructure\Provider;

use App\Core\Report\Domain\Repositories\ReadReportRepository;
use App\Core\Report\Domain\Repositories\WriteReportRepository;
use App\Core\Report\Infrastructure\Repositories\EloquentReadReportRepository;
use App\Core\Report\Infrastructure\Repositories\EloquentWriteReportRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ReportServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrations();
        $this->registerRoutes();
        $this->bindRepositories();
        $this->loadViews();
    }

    private function registerRoutes(): void
    {
        Route::group($this->routeConfig(), function () {
            $this->loadRoutesFrom(base_path('app/Core/Report/Infrastructure/routes/api.php'));
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
        $this->app->singleton(WriteReportRepository::class, EloquentWriteReportRepository::class);
        $this->app->singleton(ReadReportRepository::class, EloquentReadReportRepository::class);
    }

    private function loadMigrations(): void
    {
        $this->loadMigrationsFrom(base_path('app/Core/Report/Infrastructure/database/migrations'));

    }

    private function loadViews(): void
    {
        $this->loadViewsFrom(
            base_path('app/Core/Report/Infrastructure/views/reports'),
            'Reports'
        );
    }
}
