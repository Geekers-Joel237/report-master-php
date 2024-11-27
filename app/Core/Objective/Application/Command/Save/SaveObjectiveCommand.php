<?php

namespace App\Core\Objective\Application\Command\Save;

readonly class SaveObjectiveCommand
{
    public function __construct(
        public array $tasks,
        public array $participantIds,
        public string $projectId,
        public string $ownerId,
        public ?string $objectiveId = null,
    ) {}
}
