<?php

namespace App\Core\Report\Infrastructure\Provider;

use App\Core\Report\Domain\Repositories\WriteReportRepository;
use App\Core\Report\Infrastructure\Repositories\EloquentWriteReportRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ReportServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //        $this->loadMigrations();
        $this->registerRoutes();
        $this->bindRepositories();
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
        ];
    }

    private function bindRepositories(): void
    {
        $this->app->singleton(WriteReportRepository::class, EloquentWriteReportRepository::class);
    }
}
