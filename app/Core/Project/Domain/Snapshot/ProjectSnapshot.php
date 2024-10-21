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
}
