<?php

namespace App;

use App\Core\ACL\Infrastructure\Provider\AclServiceProvider;
use App\Core\Auth\Infrastructure\Provider\AuthServiceProvider;
use App\Core\Notification\Infrastructure\Console\Command\DailyReportReminderCommand;
use App\Core\Notification\Infrastructure\Console\Command\WeeklyLanguageReportReminderCommand;
use App\Core\Notification\Infrastructure\Console\Command\WeeklyObjectiveReminderCommand;
use App\Core\Notification\Infrastructure\Provider\NotificationServiceProvider;
use App\Core\Objective\Infrastructure\Provider\ObjectiveServiceProvider;
use App\Core\Project\Infrastructure\Provider\ProjectServiceProvider;
use App\Core\Report\Infrastructure\Provider\ReportServiceProvider;
use App\Core\Shared\Infrastructure\Provider\ConfigServiceProvider;
use App\Core\User\Infrastructure\Provider\UserServiceProvider;
use Illuminate\Support\Facades\Schedule;
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
    public function boot(): void
    {
        Schedule::timezone('Africa/Douala');
        $this->scheduleWeeklyObjectiveReminderCommand();
        $this->scheduleWeeklyLanguageReportReminderCommand();
        $this->scheduleDailyReportReminderCommand();

    }

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

    public function scheduleDailyReportReminderCommand(): void
    {
        // Exécuter la commande du lundi au jeudi à 17h50, 17h55 et 18h00
        // 1 = lundi, 2 = mardi, 3 = mercredi, 4 = jeudi
        Schedule::command(DailyReportReminderCommand::class)
            ->days([1, 2, 3, 4])
            ->at('17:50');

        Schedule::command(DailyReportReminderCommand::class)
            ->days([1, 2, 3, 4])
            ->at('17:55');

        Schedule::command(DailyReportReminderCommand::class)
            ->days([1, 2, 3, 4])
            ->at('18:00');

        // Planification spéciale uniquement pour le vendredi entre 16h50 et 17h00 (toutes les 5 minutes)
        Schedule::command(DailyReportReminderCommand::class)
            ->fridays()
            ->at('16:50');

        Schedule::command(DailyReportReminderCommand::class)
            ->fridays()
            ->at('16:55');

        Schedule::command(DailyReportReminderCommand::class)
            ->fridays()
            ->at('17:00');
    }

    private function scheduleWeeklyLanguageReportReminderCommand(): void
    {
        Schedule::command(WeeklyLanguageReportReminderCommand::class)
            ->wednesdays()
            ->at('17:50');
    }

    private function scheduleWeeklyObjectiveReminderCommand(): void
    {
        Schedule::command(WeeklyObjectiveReminderCommand::class)
            ->days([1, 2])
            ->at('10:00');

        Schedule::command(WeeklyObjectiveReminderCommand::class)
            ->days([1, 2])
            ->at('15:00');

        Schedule::command(WeeklyObjectiveReminderCommand::class)
            ->days([1, 2])
            ->at('17:00');
    }
}
