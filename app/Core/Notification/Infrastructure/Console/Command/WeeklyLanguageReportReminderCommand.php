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

class WeeklyLanguageReportReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:language-send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a weekly generic reminder to all non-admin users to write their reports in the second language';

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

            $sql = '
                SELECT u.email, u.name
                FROM users u
                    INNER JOIN model_has_roles mhr ON (u.id = mhr.model_id AND mhr.model_type = ?)
                    INNER JOIN roles r ON mhr.role_id = r.id
                WHERE u.is_deleted = 0 AND r.name NOT IN (?, ?)
                ';

            $st = $pdo->prepare($sql);
            $st->execute([User::class, ...$roles]);
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
        $message = "Hello,\n\n"
            ."Les rapports s'écrivent en français pour les anglophones et en anglais pour les francophones ";

        return new SendNotificationDto(
            subject: 'Journée de promotion du bilinguisme - '.date('Y-m-d'),
            to: $users,
            message: $message
        );
    }
}
