<?php

namespace App\Core\Report\Application\Command\Save;

readonly class SaveReportCommand
{
    public function __construct(
        public array $tasks,
        public array $participants,
        public string $projectId,
        public ?string $reportId = null,
    ) {}
}
