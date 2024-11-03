<?php

namespace App\Core\Project\Domain\Snapshot;

readonly class ProjectSnapshot
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $description,
        public string $status,
        public ?string $createdAt,
        public ?string $updatedAt,
    ) {}

    /**
     * @return array<string, string|null>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
