<?php

namespace App\Core\Project\Domain\Repository;

use App\Core\Project\Domain\Entities\Project;

interface WriteProjectRepository
{
    public function save(Project $project): void;

    public function ofId(string $projectId): ?Project;

    public function ofName(string $value): ?Project;
}
