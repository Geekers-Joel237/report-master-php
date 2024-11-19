<?php

namespace App\Core\Project\Infrastructure\Repositories;

use App\Core\Project\Application\Query\All\ProjectDto;
use App\Core\Project\Domain\Repositories\ReadProjectRepository;
use Illuminate\Support\Facades\DB;

class SqlReadProjectRepository implements ReadProjectRepository
{
    /**
     * @return ProjectDto[]
     */
    public function all(?string $year, ?string $status): array
    {
        $sql = '
            SELECT 
                projects.id AS projectId,
                projects.name,
                projects.description,
                projects.status,
                projects.created_at AS createdAt,
                projects.updated_at AS updatedAt,
                projects.year_id AS yearId,
                years.year AS year
            FROM projects
            JOIN years ON projects.year_id = years.id
            WHERE 1 = 1
        ';

        $tab = [];
        if ($year) {
            $sql .= ' AND years.year = :year';
            $tab['year'] = $year;
        }
        if ($status) {
            $sql .= ' AND projects.status = :status';
            $tab['status'] = $status;
        }

        $results = DB::select($sql, $tab);

        return array_map(function ($row) {
            return (array) $row;
        }, $results);
    }
}
