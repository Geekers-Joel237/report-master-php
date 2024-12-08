<?php

namespace App\Core\Report\Tests\E2E;

use App\Core\Project\Infrastructure\Models\Project;
use App\Core\Report\Infrastructure\Models\Report;
use App\Core\Shared\Infrastructure\Models\Years;
use App\Core\User\Infrastructure\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Random\RandomException;

class ReportSUT
{
    public Collection|Model|Project $project;

    public array $tasks;

    public array $participants;
    private Collection|Model $year;

    public static function asSUT(): static
    {

        $static = new static;
        $static->year = Years::factory()->create();
        return $static;
    }

    public function withProject(): static
    {
        $this->project = Project::factory()->create(['year_id' => $this->year->id]);

        return $this;
    }

    public function build(): static
    {
        return $this;
    }

    /**
     * @throws RandomException
     */
    public function withTasks(int $nbTasks): static
    {
        $this->tasks = $this->generateRandomStrings($nbTasks);

        return $this;
    }

    /**
     * @throws RandomException
     */
    public function generateRandomStrings(int $n, int $length = 8): array
    {
        $randomStrings = [];
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        for ($i = 0; $i < $n; $i++) {
            $randomString = '';
            for ($j = 0; $j < $length; $j++) {
                $randomString .= $characters[random_int(0, strlen($characters) - 1)];
            }
            $randomStrings[] = $randomString;
        }

        return $randomStrings;
    }

    public function withParticipants(int $nbParticipants): static
    {

        $this->participants[] = User::factory()->count($nbParticipants)
            ->create()->pluck('id')->toArray();

        return $this;
    }

    public function withReports(int $nbReports): static
    {
        Report::factory()->count($nbReports)->create([
            'project_id' => $this->project->id,
        ]);

        return $this;
    }
}
