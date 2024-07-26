<?php

namespace App\Core\Project\Domain\Repositories;

use App\Core\Project\Domain\Entities\Project;
use App\Core\Project\Domain\Exceptions\ErrorOnSaveProjectException;

interface WriteProjectRepository
{
    /**
     * @throws ErrorOnSaveProjectException
     */
    public function save(Project $project): void;

    public function ofId(string $projectId): ?Project;

    public function ofName(string $value): ?Project;

    /**
     * @throws ErrorOnSaveProjectException
     */
    public function delete(string $existingProjectId): void;

    public function exists(string $projectId): bool;
}
