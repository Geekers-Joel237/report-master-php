<?php

namespace App\Core\Notification\Infrastructure\Provider;

use App\Core\Notification\Infrastructure\Console\Command\DailyReportReminderCommand;
use App\Core\Notification\Infrastructure\Console\Command\WeeklyLanguageReportReminderCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                DailyReportReminderCommand::class,
                WeeklyLanguageReportReminderCommand::class,
            ]);
        }

        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);

            $schedule->command('reminders-report:weekly-language')->weeklyOn(3, '18:00');
        });

    }

    public function register(): void
    {
        $this->loadViewsFrom(
            base_path('app/Core/Notification/Infrastructure/views'),
            'Mail');
    }
}
