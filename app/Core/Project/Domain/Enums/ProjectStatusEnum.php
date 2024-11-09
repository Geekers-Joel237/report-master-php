<?php

namespace App\Core\Project\Domain\Enums;

use App\Core\Shared\Domain\Exceptions\InvalidCommandException;

enum ProjectStatusEnum: string
{
    case Started = 'Démarré';
    case InProgress = 'En cours';
    case OnHold = 'En attente';
    case Completed = 'Terminé';
    case Archived = 'Archivé';

    /**
     * @throws InvalidCommandException
     */
    public static function in(string $status): self
    {
        $self = self::tryFrom($status);
        if (is_null($self)) {
            throw new InvalidCommandException('Ce status n\'est pas pris en compte !');
        }

        return $self;
    }
}
