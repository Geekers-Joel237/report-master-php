<?php

namespace App\Core\Notification\Infrastructure\Console\Command;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendReminderEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails to project participants who are not admins';

    public function handle(): void
    {

        $participants = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('roles.name', '!=', 'admin')
            ->join('project_participants', 'users.id', '=', 'project_participants.user_id')
            ->join('projects', 'project_participants.project_id', '=', 'projects.id')
            ->select('users.email', 'projects.name as project_name')
            ->get();

        foreach ($participants as $participant) {
            Mail::raw(
                "Bonjour,\n\nCeci est un rappel pour votre participation au projet \"$participant->project_name\".\n\nMerci !",
                function ($message) use ($participant) {
                    $message->to($participant->email)
                        ->subject('Rappel de participation au projet');
                }
            );
        }

        $this->info('Les emails de rappel ont été envoyés avec succès.');
    }
}
