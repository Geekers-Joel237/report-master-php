<?php

namespace App\Core\Domain\Repository\Project;

use App\Core\Domain\Entities\Project;

interface WriteProjectRepository
{
    public function save(Project $project): void;

    public function ofId(string $projectId): ?Project;

    public function ofName(string $value): ?Project;
}
