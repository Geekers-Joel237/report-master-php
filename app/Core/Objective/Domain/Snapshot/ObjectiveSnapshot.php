<?php

namespace App\Core\Objective\Domain\Snapshot;

readonly class ObjectiveSnapshot
{
    public function __construct(
        public string $id,
        public string $projectId,
        public string $ownerId,
        public array $tasks,
        public array $participantIds,
        public ?string $createdAt,
        public ?string $updatedAt,
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'project_id' => $this->projectId,
            'owner_id' => $this->ownerId,
            'tasks' => json_encode($this->tasks),
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
