<?php

namespace App\Core\Report\Domain\Repositories;

use App\Core\Report\Domain\Dto\FilterReportParams;

interface ReadReportRepository
{
    public function filter(FilterReportParams $params): array;
}
