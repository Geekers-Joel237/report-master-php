<?php

namespace App\Core\Report\Domain\Enums;

enum ReportMessageEnum
{
    const SAVE = 'Nouveau Rapport ajouté avec succès !';

    const NOT_FOUND_REPORT = 'Ce rapport est introuvable !';

    const UPDATED = 'Rapport modifié avec succès !';
}
