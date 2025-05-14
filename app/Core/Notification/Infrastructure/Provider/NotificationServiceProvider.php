<?php

namespace App\Core\Notification\Infrastructure\Provider;

use App\Core\Notification\Domain\Notifier;
use App\Core\Notification\Infrastructure\Console\Command\DailyReportReminderCommand;
use App\Core\Notification\Infrastructure\Console\Command\WeeklyLanguageReportReminderCommand;
use App\Core\Notification\Infrastructure\Console\Command\WeeklyObjectiveReminderCommand;
use App\Core\Notification\Infrastructure\MailNotifier;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                DailyReportReminderCommand::class,
                WeeklyLanguageReportReminderCommand::class,
                WeeklyObjectiveReminderCommand::class,
            ]);
        }

    }

    public function register(): void
    {
        $this->loadViewsFrom(
            base_path('app/Core/Notification/Infrastructure/views'),
            'Mail');
        $this->app->singleton(Notifier::class, MailNotifier::class);

    }
}
