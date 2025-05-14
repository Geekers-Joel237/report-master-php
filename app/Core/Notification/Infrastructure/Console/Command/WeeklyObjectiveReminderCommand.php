<?php

namespace App\Core\Notification\Infrastructure\Console\Command;

use App\Core\ACL\Domain\Enums\RoleEnum;
use App\Core\Notification\Domain\Notifier;
use App\Core\Notification\Infrastructure\Dto\SendNotificationDto;
use App\Core\User\Infrastructure\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDO;
use Throwable;

class WeeklyObjectiveReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:objective-send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a weekly generic reminder to all non-admin users to write their objectives';

    public function __construct(
        private readonly Notifier $notifier,
    ) {
        parent::__construct();
    }

    public function handle(): void
    {
        try {
            $pdo = DB::connection()->getPdo();

            $roles = [RoleEnum::ADMIN->value, RoleEnum::SUPER_ADMIN->value];
            // Calculer le lundi et le mardi de la semaine courante
            $currentDayOfWeek = date('N'); // 1 (lundi) à 7 (dimanche)
            $daysToMonday = $currentDayOfWeek - 1;
            $monday = date('Y-m-d 00:00:00', strtotime("-$daysToMonday days")); // Lundi à 00:00:00
            $tuesday = date('Y-m-d 23:59:59', strtotime("-$daysToMonday days +1 day")); // Mardi à 23:59:59
            $sql = '
                SELECT u.email, u.name
                FROM users u
                    INNER JOIN model_has_roles mhr ON (u.id = mhr.model_id AND mhr.model_type = ?)
                    INNER JOIN roles r ON mhr.role_id = r.id
                WHERE u.is_deleted = 0 AND r.name NOT IN (?, ?) AND
                      NOT EXISTS (
                          SELECT 1
                          FROM objectives o
                          WHERE u.id = o.owner_id AND o.created_at BETWEEN ? AND ?
                      )

                ';

            $st = $pdo->prepare($sql);
            $st->execute([User::class, ...$roles, $monday, $tuesday]);
            $users = $st->fetchAll(PDO::FETCH_ASSOC);

            $dto = $this->buildSendNotificationDto($users);
            $this->notifier->send($dto);
            Log::info('Weekly report reminders sent successfully.');
        } catch (Throwable $e) {
            Log::error($e->getMessage());
        }

    }

    /**
     * Construire un DTO pour l'e-mail.
     */
    private function buildSendNotificationDto(array $users): SendNotificationDto
    {
        // Message générique
        $message = "Vous n'avez pas encore soumis vos objectifs de la semaine !";

        return new SendNotificationDto(
            subject: 'Rappel objectifs de la semaine - '.date('Y-m-d'),
            to: $users,
            message: $message
        );
    }
}
