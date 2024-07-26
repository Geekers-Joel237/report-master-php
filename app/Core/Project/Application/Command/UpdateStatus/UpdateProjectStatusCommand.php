<?php

namespace App\Core\Project\Application\Command\UpdateStatus;

readonly class UpdateProjectStatusCommand
{
    public function __construct(
        public string $projectId,
        public string $status
    ) {}
}
