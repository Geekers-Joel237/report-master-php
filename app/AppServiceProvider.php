<?php

namespace App;

use App\Core\ACL\Infrastructure\Provider\AclServiceProvider;
use App\Core\Auth\Infrastructure\Provider\AuthServiceProvider;
use App\Core\Notification\Infrastructure\Provider\NotificationServiceProvider;
use App\Core\Objective\Infrastructure\Provider\ObjectiveServiceProvider;
use App\Core\Project\Infrastructure\Provider\ProjectServiceProvider;
use App\Core\Report\Infrastructure\Provider\ReportServiceProvider;
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
        $this->app->register(AclServiceProvider::class);
        $this->app->register(UserServiceProvider::class);
        $this->app->register(ProjectServiceProvider::class);
        $this->app->register(ReportServiceProvider::class);
        $this->app->register(ObjectiveServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(NotificationServiceProvider::class);
    }
}
