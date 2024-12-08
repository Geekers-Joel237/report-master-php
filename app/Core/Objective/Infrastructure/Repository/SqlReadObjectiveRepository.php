<?php

namespace App\Core\Objective\Infrastructure\Repository;

use App\Core\Shared\Lib\PdoConnection;
use PDO;

class SqlReadObjectiveRepository
{
    public function __construct(
        private PdoConnection $connection
    ) {}

    public function all(?string $projetId, ?string $startDate, ?string $endDate, ?string $year, ?string $ownerId, ?array $participantIds): array
    {
        $params = [];
        $clause = 'o.is_deleted = 0';
        if ($year) {
            $clause .= ' AND y.year = :year';
            $params['year'] = $year;
        }
        if ($startDate) {
            $clause .= ' AND o.created_at >= :startDate';
            $params['startDate'] = $startDate;
        }
        if ($endDate) {
            $clause .= ' AND o.created_at <= :endDate';
            $params['endDate'] = $endDate;
        }
        if ($projetId) {
            $clause .= ' AND p.id = :projectId';
            $params['projetId'] = $projetId;
        }
        if ($ownerId) {
            $clause .= ' AND u.id = :ownerId';
            $params['ownerId'] = $ownerId;
        }
        if ($participantIds) {
            foreach ($participantIds as $index => $participantId) {
                $clause .= "
                    SELECT o.id AS objectifId
                    FROM objectifs_participants op
                    WHERE op.participant_id = :participant_$index
                ";
                $params["participant_$index"] = $participantId;

                if ($index < count($participantIds) - 1) {
                    $clause .= ' INTERSECT ';
                }
            }
        }

        $sql = "
            SELECT
                o.id AS objectiveId,
                o.created_at AS createdAt,
                o.updated_at AS updatedAt,
                y.id AS yearId,
                y.year
            FROM objectives o
            INNER JOIN years y ON o.year_id = yearId
            INNER JOIN projects p on o.project_id = p.id
            INNER JOIN users u on o.owner_id = u.id
            WHERE $clause
        ";

        $query = $this->connection->getPdo()->prepare($sql);
        $query->execute($params);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
