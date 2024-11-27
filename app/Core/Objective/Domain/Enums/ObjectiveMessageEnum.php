<?php

namespace App\Core\Objective\Domain\Enums;

class ObjectiveMessageEnum: string
{
    const SAVE = 'Nouvel objectif ajouté avec succès !';

    const NOT_FOUND_OBJECTIVE = 'Cet objectif est introuvable !';

    const UPDATED = 'Objectif modifié avec succès !';

    const DELETED = 'Objectif supprimé avec succès !';
}
