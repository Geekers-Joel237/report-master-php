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
    public function all(?string $year, ?string $status): array
    {
        return Project::join('years', 'projects.year_id', '=', 'years.id')
            ->select([
                'projects.id as projectId',
                'projects.name',
                'projects.description',
                'projects.status',
                'projects.created_at as createdAt',
                'projects.updated_at as updatedAt',
                'projects.year_id as yearId',
                'years.year as year',
            ])
            ->when($year, function ($query, $year) {
                return $query->where('years.year', $year);
            })->when($status, function ($query, $status) {
                return $query->where('projects.status', $status);
            })->get()->toArray();
    }
}
