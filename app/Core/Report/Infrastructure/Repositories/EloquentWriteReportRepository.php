<?php

namespace App\Core\Report\Infrastructure\Repositories;

use App\Core\Report\Domain\Entities\DailyReport;
use App\Core\Report\Domain\Repositories\WriteReportRepository;
use App\Core\Report\Domain\Snapshots\ReportSnapshot;
use Exception;
use Throwable;

class EloquentWriteReportRepository implements WriteReportRepository
{
    public function ofId(string $reportId): ?DailyReport
    {
        // TODO: Implement ofId() method.
    }

    public function save(ReportSnapshot $report): void
    {
        try {

        } catch (Throwable|Exception $e) {

        }
    }

    public function exists(string $reportId): bool
    {
        // TODO: Implement exists() method.
    }

    public function delete(string $reportId): void
    {
        // TODO: Implement delete() method.
    }
}
