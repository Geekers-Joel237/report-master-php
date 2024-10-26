<?php

namespace App\Core\Project\Infrastructure\Repository;

use App\Core\Project\Domain\Entities\Project;
use App\Core\Project\Domain\Repositories\WriteProjectRepository;
use App\Core\Project\Domain\Snapshot\ProjectSnapshot;
use App\Core\Project\Infrastructure\Models\Project as ProjectModel;

class EloquentProjectRepository implements WriteProjectRepository
{
    public function ofId(string $projectId): ?Project
    {
        return ProjectModel::findOrFail($projectId)?->createFromModel();
    }

    public function ofName(string $value): ?Project
    {
        // TODO: Implement ofName() method.
    }

    public function delete(string $existingProjectId): void
    {
        // TODO: Implement delete() method.
    }

    public function exists(string $projectId): bool
    {
        // TODO: Implement exists() method.
    }

    public function save(ProjectSnapshot $project): void
    {
        // TODO: Implement save() method.
    }
}
