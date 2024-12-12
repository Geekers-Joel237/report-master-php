<?php

namespace App\Core\User\Infrastructure\Repository;

use App\Core\Shared\Lib\PdoConnection;
use App\Core\User\Domain\Dto\UserProfileDto;
use App\Core\User\Domain\Repository\ReadUserRepository;
use App\Core\User\Infrastructure\Models\User;

readonly class SqlReadUserRepository implements ReadUserRepository
{
    public function __construct(
        private PdoConnection $connection
    ) {}

    public function profile(string $userId): ?UserProfileDto
    {
        $modelType = User::class;
        $sql = 'SELECT
                    u.id userId,
                    u.name,
                    u.email,
                    r.id roleId,
                    r.name roleName
                FROM users u
                INNER JOIN model_has_roles mhr ON (u.id = mhr.model_id AND mhr.model_type = ?)
                INNER JOIN roles r ON mhr.role_id = r.id
                WHERE u.id = ? AND u.is_deleted = 0 AND r.is_active = 1
                LIMIT 1';
        $st = $this->connection->getPdo()->prepare($sql);
        $st->execute([$modelType, $userId]);

        return $st->fetchObject(UserProfileDto::class);
    }
}
