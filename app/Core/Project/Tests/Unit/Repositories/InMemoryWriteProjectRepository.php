<?php

namespace App\Core\Project\Tests\Unit\Repositories;

use App\Core\Project\Domain\Entities\Project;
use App\Core\Project\Domain\Repositories\WriteProjectRepository;
use App\Core\Project\Domain\Snapshot\ProjectSnapshot;
use Exception;

class InMemoryWriteProjectRepository implements WriteProjectRepository
{
    /**
     * @var ProjectSnapshot[]
     */
    private array $projectSnapshots = [];

    public function save(ProjectSnapshot $project): void
    {
        $this->projectSnapshots[$project->id] = $project;
    }

    /**
     * @throws Exception
     */
    public function ofId(string $projectId): ?Project
    {
        return array_key_exists($projectId, $this->projectSnapshots) ? $this->toDomain($this->projectSnapshots[$projectId]) : null;
    }

    /**
     * @throws Exception
     */
    public function toDomain(ProjectSnapshot $projectSnapshot): Project
    {
        return Project::createFromAdapter(
            id: $projectSnapshot->id,
            name: $projectSnapshot->name,
            status: $projectSnapshot->status,
            description: $projectSnapshot->description,
            createdAt: $projectSnapshot->createdAt,
            updatedAt: $projectSnapshot->updatedAt,
        );
    }

    /**
     * @throws Exception
     */
    public function ofName(string $value): ?Project
    {
        $projects = array_values(array_filter($this->projectSnapshots, function (ProjectSnapshot $project) use ($value) {
            return $project->name === $value;
        }));

        return empty($projects) ? null : $this->toDomain($projects[0]);
    }

    public function delete(string $existingProjectId): void
    {
        unset($this->projectSnapshots[$existingProjectId]);
    }

    public function exists(string $projectId): bool
    {
        return array_key_exists($projectId, $this->projectSnapshots);
    }
}
