<?php

namespace App\Core\Report\Domain\Snapshots;

readonly class ReportSnapshot
{
    public function __construct(
        public string $id,
        public string $projectId,
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
            'tasks' => json_encode($this->tasks),
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
