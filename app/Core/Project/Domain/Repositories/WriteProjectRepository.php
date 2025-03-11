<?php

namespace App\Core\Project\Domain\Repositories;

use App\Core\Project\Domain\Entities\Project;
use App\Core\Project\Domain\Exceptions\ErrorOnSaveProjectException;
use App\Core\Project\Domain\Snapshot\ProjectSnapshot;

interface WriteProjectRepository
{
    /**
     * @throws ErrorOnSaveProjectException
     */
    public function create(ProjectSnapshot $project): void;

    public function ofId(string $projectId): ?Project;

    public function ofSlug(string $slug): ?Project;

    /**
     * @throws ErrorOnSaveProjectException
     */
    public function delete(string $existingProjectId): void;

    public function exists(string $projectId): bool;

    public function update(ProjectSnapshot $project): void;
}
