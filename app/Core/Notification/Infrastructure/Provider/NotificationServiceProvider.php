<?php

namespace App\Core\Notification\Infrastructure\Provider;

use App\Core\Notification\Infrastructure\Console\Command\DailyReportReminderCommand;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                DailyReportReminderCommand::class,
            ]);
        }
    }

    public function register(): void
    {
        $this->loadViewsFrom(
            base_path('app/Core/Notification/Infrastructure/views'),
            'Mail');
    }
}
