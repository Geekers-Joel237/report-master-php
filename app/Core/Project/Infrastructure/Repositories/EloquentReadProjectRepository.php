<?php

namespace App\Core\Project\Infrastructure\Repositories;

use App\Core\Project\Application\Query\All\ProjectDto;
use App\Core\Project\Domain\Repositories\ReadProjectRepository;
use App\Core\Project\Infrastructure\Models\Project;
use App\Core\Shared\Infrastructure\Models\Years;

class EloquentReadProjectRepository implements ReadProjectRepository
{
    /**
     * @return ProjectDto[]
     */
    public function all(?string $year, ?string $status): array
    {
        return Project::select([
            'id as projectId',
            'name',
            'description',
            'status',
            'created_at as createdAt',
            'updated_at as updatedAt',
        ])->when($year, function ($query, $year) {
            return $query->where('year_id', Years::select(['id'])->where('year', $year)->first()?->id);
        })->when($status, function ($query, $status) {
            return $query->where('status', $status);
        })->get()->toArray();
    }
}
