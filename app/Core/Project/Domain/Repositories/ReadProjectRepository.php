<?php

namespace App\Core\Project\Domain\Repositories;

use App\Core\Project\Application\Query\All\ProjectDto;

interface ReadProjectRepository
{
    /**
     * @return ProjectDto[]
     */
    public function all(): array;
}
