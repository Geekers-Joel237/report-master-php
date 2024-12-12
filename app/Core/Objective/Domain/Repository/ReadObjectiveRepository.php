<?php

namespace App\Core\Objective\Domain\Repository;

use App\Core\Objective\Domain\Dto\FilterObjectiveParams;

interface ReadObjectiveRepository
{
    public function filter(FilterObjectiveParams $params): array;
}
