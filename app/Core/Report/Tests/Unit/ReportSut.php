<?php

namespace App\Core\Report\Tests\Unit;

use App\Core\Project\Domain\Entities\Project;
use App\Core\Project\Domain\Vo\NameVo;
use App\Core\Report\Domain\Entities\DailyReport;
use App\Core\Shared\Domain\Exceptions\InvalidCommandException;

class ReportSut
{
    public Project $project;

    public array $participants;

    public DailyReport $report;

    public static function asSUT(): static
    {
        return new static;
    }

    public function withProject(): static
    {
        $this->project = Project::create(
            id: '001',
            name: new NameVo('my-project-name'),
            slug: 'my-project-name'
        );

        return $this;
    }

    public function build(): static
    {
        return $this;
    }

    public function withParticipants(array $participantIds): static
    {
        $this->participants = $participantIds;

        return $this;
    }

    /**
     * @throws InvalidCommandException
     */
    public function withReport(): static
    {
        $this->report = DailyReport::create(
            projectId: $this->project->snapshot()->id,
            tasks: [
                "Lorem Ipsum is simply dummy text of the printing and typesetting industry.
            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
            when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            It has survived not only five centuries, but also the leap into electronic typesetting,
            remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets
            containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
             PageMaker including versions of Lorem Ipsum.",
            ], participants: [], reportId: '001'
        );

        return $this;
    }
}
