<?php

namespace App\Core\Shared\Infrastructure\Console;

use App\Core\Notification\Infrastructure\Console\Command\SendReminderEmails;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        SendReminderEmails::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Planifier la commande personnalisée
        $schedule->command('reminders:send')->dailyAt('08:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        // Charger automatiquement les commandes
        $this->load(base_path('app/Core/Shared/Infrastructure/Console/Commands'));

        // Inclure des commandes personnalisées ici si nécessaire
        require base_path('routes/console.php');
    }
}
