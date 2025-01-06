<?php

namespace App\Core\Notification\Infrastructure\Console\Command;

use App\Core\ACL\Domain\Enums\RoleEnum;
use App\Core\Notification\Infrastructure\Dto\SendEmailForLanguageDto;
use App\Core\Notification\Infrastructure\Mail\SendEmailForLanguage;
use App\Core\User\Infrastructure\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PDO;
use Throwable;

class WeeklyLanguageReportReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders-report:weekly-language';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a weekly generic reminder to all non-admin users to write their reports in the second language';

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
                Mail::to($dto->recipient)->send(new SendEmailForLanguage($dto));
            }
        } catch (Throwable|Exception $e) {
            $this->error("Error: {$e->getMessage()}");
        }

        $this->info('Weekly report reminders sent successfully.');
    }

    /**
     * Construire un DTO pour l'e-mail.
     */
    private function buildSendEmailDto(array $user): SendEmailForLanguageDto
    {
        // Message générique
        $message = "Hello,\n\n"
            . "This is a friendly reminder to submit your weekly report for the ongoing projects.\n\n"
            . "If you are a French speaker, please ensure that your report is written in **English**.\n"
            . "If you are an English speaker, please ensure that your report is written in **French**.\n\n"
            . "Timely submission of your report helps us maintain smooth communication and project progress.\n\n"
            . "Thank you for your cooperation!\n\n"
            . "Best regards,\n"
            . "The Project Management Team\n\n"
            . "---\n\n"
            . "Bonjour,\n\n"
            . "Ceci est un rappel amical pour soumettre votre rapport hebdomadaire pour les projets en cours.\n\n"
            . "Si vous êtes francophone, veuillez vous assurer que votre rapport est rédigé en **anglais**.\n"
            . "Si vous êtes anglophone, veuillez vous assurer que votre rapport est rédigé en **français**.\n\n"
            . "La soumission en temps voulu de votre rapport nous aide à maintenir une communication fluide et une bonne progression des projets.\n\n"
            . "Merci pour votre coopération !\n\n"
            . "Cordialement,\n"
            . "L'équipe de gestion de projet";

        return new SendEmailForLanguageDto(
            object: 'Weekly Report Reminder - '.date('Y-m-d'),
            recipient: $user['email'],
            recipientName: $user['name'],
            message: $message
        );
    }
}
