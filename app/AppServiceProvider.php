<?php

namespace App;

use App\Core\Project\Infrastructure\Provider\ProjectServiceProvider;
use App\Core\Shared\Infrastructure\Provider\ConfigServiceProvider;
use App\Core\User\Infrastructure\Provider\UserServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerModules();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}

    private function registerModules(): void
    {
        $this->app->register(ConfigServiceProvider::class);
        $this->app->register(UserServiceProvider::class);
        $this->app->register(ProjectServiceProvider::class);
    }
}
