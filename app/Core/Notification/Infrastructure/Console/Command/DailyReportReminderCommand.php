<?php

namespace App\Core\Notification\Infrastructure\Console\Command;

use App\Core\ACL\Domain\Enums\RoleEnum;
use App\Core\Notification\Infrastructure\Dto\SendEmailDto;
use App\Core\Notification\Infrastructure\Mail\SendEmail;
use App\Core\User\Infrastructure\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PDO;
use Throwable;

class DailyReportReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders-report:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder daily report emails to users who are not admins';

    public function handle(): void
    {
        try {
            $pdo = DB::connection()->getPdo();

            $roles = [RoleEnum::ADMIN->value, RoleEnum::SUPER_ADMIN->value];
            $placeholders = str_repeat('?,', count($roles) - 1).'?';

            $sql = '
                SELECT u.email, u.name
                FROM users u
                    INNER JOIN model_has_roles mhr ON (u.id = mhr.model_id AND mhr.model_type = ?)
                    INNER JOIN roles r ON mhr.role_id = r.id
                WHERE u.is_deleted = 0 AND r.name NOT IN ('.$placeholders.')
                ';

            $st = $pdo->prepare($sql);
            $st->execute([User::class, ...$roles]);
            $users = $st->fetchAll(PDO::FETCH_ASSOC);

            foreach ($users as $user) {
                $dto = $this->buildSendEmailDto($user);
                Mail::to($dto->recipient)->send(new SendEmail($dto));

            }
        } catch (Throwable|Exception $e) {
            dd($e);
        }

        $this->info('all is ok');
    }

    private function buildSendEmailDto(array $user): SendEmailDto
    {
        return new SendEmailDto(
            object: 'Rédaction de rapport '.date('Y-m-d'),
            recipient: $user['email'],
            recipientName: $user['name']
        );
    }
}
