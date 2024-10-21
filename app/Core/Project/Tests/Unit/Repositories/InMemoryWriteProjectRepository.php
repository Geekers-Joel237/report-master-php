<?php

namespace App\Core\Project\Tests\Unit\Repositories;

use App\Core\Project\Domain\Entities\Project;
use App\Core\Project\Domain\Repositories\WriteProjectRepository;

class InMemoryWriteProjectRepository implements WriteProjectRepository
{
    /**
     * @var Project[]
     */
    private array $projects = [];

    public function save(Project $project): void
    {
        $this->projects[$project->id] = $project;
    }

    public function ofId(string $projectId): ?Project
    {
        return array_key_exists($projectId, $this->projects) ? $this->projects[$projectId] : null;
    }

    public function ofName(string $value): ?Project
    {
        return array_values(array_filter($this->projects, function (Project $project) use ($value) {
            return $project->name->value() === $value;
        }))[0] ?? null;
    }

    public function delete(string $existingProjectId): void
    {
        unset($this->projects[$existingProjectId]);
    }

    public function exists(string $projectId): bool
    {
        return array_key_exists($projectId, $this->projects);
    }
}
