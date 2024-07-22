<?php

namespace App\Core\Project\Domain\Enums;

enum ProjectStatusEnum: string
{
    case Started = 'Démarré';
    case InProgress = 'En cours';
    case OnHold = 'En attente';
    case Completed = 'Terminé';
    case Archived = 'Archivé';

}
