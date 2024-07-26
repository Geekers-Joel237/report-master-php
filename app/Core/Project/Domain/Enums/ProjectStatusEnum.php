<?php

namespace App\Core\Project\Domain\Enums;

use InvalidArgumentException;

enum ProjectStatusEnum: string
{
    case Started = 'Démarré';
    case InProgress = 'En cours';
    case OnHold = 'En attente';
    case Completed = 'Terminé';
    case Archived = 'Archivé';

    /**
     * @throws InvalidArgumentException
     */
    public static function in(string $status): self
    {
        $self = self::tryFrom($status);
        if (is_null($self)) {
            throw new InvalidArgumentException('Ce status n\'est pas pris en compte !');
        }

        return $self;
    }
}
