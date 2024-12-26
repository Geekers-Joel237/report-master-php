<?php

namespace App\Core\Notification\Infrastructure\Provider;

use App\Core\Notification\Infrastructure\Console\Command\SendReminderEmails;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SendReminderEmails::class,
            ]);
        }
    }
}
