<?php

namespace Tests\Unit\Project\Repository;

use App\Core\Domain\Entities\Project;
use App\Core\Domain\Repository\Project\WriteProjectRepository;

class InMemoryWriteProjectRepository implements WriteProjectRepository
{
    private array $projects = [];

    public function create(Project $project): void
    {
        $this->projects[$project->id] = $project;
    }

    public function ofId(string $projectId): ?Project
    {
        return array_key_exists($projectId, $this->projects) ? $this->projects[$projectId] : null;
    }
}
