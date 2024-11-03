<?php

namespace App\Core\Report\Domain\Snapshots;

readonly class ReportSnapshot
{
    public function __construct(
        public string $id,
        public string $projectId,
        public array $tasks,
        public array $participants,
        public ?string $createdAt,
        public ?string $updatedAt,
    ) {}
}
