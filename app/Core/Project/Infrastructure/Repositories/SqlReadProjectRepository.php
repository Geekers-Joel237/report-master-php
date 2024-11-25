<?php

namespace App\Core\Project\Infrastructure\Repositories;

use App\Core\Project\Application\Query\All\ProjectDto;
use App\Core\Project\Domain\Repositories\ReadProjectRepository;
use App\Core\Shared\Lib\PdoConnection;
use PDO;

readonly class SqlReadProjectRepository implements ReadProjectRepository
{
    public function __construct(
        private PdoConnection $connection
    ) {}

    /**
     * @return ProjectDto[]
     */
    public function all(?string $year, ?string $status): array
    {
        $params = [];
        $clause = 'p.is_deleted = 0';
        if ($year) {
            $clause .= ' AND y.year = :year';
            $params['year'] = $year;
        }
        if ($status) {
            $clause .= ' AND p.status = :status';
            $params['status'] = $status;
        }
        $sql = "
            SELECT
                p.id AS projectId,
                p.name,
                p.description,
                p.status,
                p.created_at AS createdAt,
                p.updated_at AS updatedAt,
                y.id AS yearId,
                y.year
            FROM projects p
            INNER JOIN years y ON p.year_id = y.id
            WHERE $clause
        ";

        $st = $this->connection->getPdo()->prepare($sql);
        $st->execute($params);

        return $st->fetchAll(PDO::FETCH_CLASS, ProjectDto::class);
    }
}
