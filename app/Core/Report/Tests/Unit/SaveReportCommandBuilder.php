<?php

namespace App\Core\Report\Tests\Unit;

use App\Core\Report\Application\Command\Save\SaveReportCommand;

class SaveReportCommandBuilder
{
    private ?string $projectId;

    private array $tasks;

    private array $participants;

    public static function asBuilder(): static
    {
        $static = new static;
        $static->projectId = null;
        $static->tasks = [];
        $static->participants = [];

        return $static;
    }

    public function withProject(string $id): static
    {
        $this->projectId = $id;

        return $this;
    }

    public function withTask(string $description): static
    {
        $this->tasks[] = $description;

        return $this;
    }

    public function withParticipants(array $participants): static
    {
        $this->participants = $participants;

        return $this;
    }

    public function build(): SaveReportCommand
    {
        return new SaveReportCommand(
            tasks: $this->tasks,
            participantIds: $this->participants,
            projectId: $this->projectId
        );
    }
}
