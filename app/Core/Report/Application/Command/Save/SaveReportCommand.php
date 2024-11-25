<?php

namespace App\Core\Report\Application\Command\Save;

readonly class SaveReportCommand
{
    public function __construct(
        public array $tasks,
        public array $participantIds,
        public string $projectId,
        public string $ownerId,
        public ?string $reportId = null,
    ) {}
}
