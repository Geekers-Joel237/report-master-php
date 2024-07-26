<?php

namespace App\Core\Project\Domain\Repositories;

interface ReadProjectRepository
{
    public function exists(string $projectId): bool;
}
