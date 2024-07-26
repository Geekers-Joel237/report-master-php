<?php

namespace App\Core\Project\Application\Command\Save;

readonly class SaveProjectCommand
{
    public function __construct(
        public string $name,
        public ?string $description = null,
        public ?string $projectId = null,
    ) {}
}
