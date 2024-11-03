<?php

namespace App\Core\Project\Infrastructure\Repositories;

use App\Core\Project\Application\Query\All\ProjectDto;
use App\Core\Project\Domain\Repositories\ReadProjectRepository;
use App\Core\Project\Infrastructure\Models\Project;

class EloquentReadProjectRepository implements ReadProjectRepository
{
    /**
     * @return ProjectDto[]
     */
    public function all(): array
    {
        return Project::select([
            'id as projectId',
            'name',
            'description',
            'status',
            'created_at as createdAt',
            'updated_at as updatedAt',
        ])->get()->toArray();
    }
}
