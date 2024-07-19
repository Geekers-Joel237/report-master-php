<?php

namespace App\Core\Domain\Repository\Project;

use App\Core\Domain\Entities\Project;

interface WriteProjectRepository
{
    public function create(Project $project): void;

    public function ofId(string $projectId): ?Project;
}
