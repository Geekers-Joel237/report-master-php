<?php

namespace App\Core\Report\Domain\Repositories;

use App\Core\Report\Domain\Entities\Report;
use App\Core\Report\Domain\Snapshots\ReportSnapshot;

interface WriteReportRepository
{
    public function ofId(string $reportId): ?Report;

    public function save(ReportSnapshot $report): void;

    public function exists(string $reportId): bool;

    public function delete(string $reportId): void;
}
