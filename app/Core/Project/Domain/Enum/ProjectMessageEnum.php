<?php

namespace App\Core\Project\Domain\Enum;

enum ProjectMessageEnum: string
{
    const SAVE = 'Nouveau projet ajouté avec succès !';

    const UPDATED = 'Projet modifié avec succès !';

    const DELETED = 'Projet supprimé avec succès !';

    const NOT_FOUND_PROJECT = 'Ce projet est introuvable !';
}
