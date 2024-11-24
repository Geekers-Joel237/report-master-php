<?php

namespace App\Core\Report\Domain\Repositories;

use App\Core\Report\Domain\Entities\DailyReport;
use App\Core\Report\Domain\Exceptions\ErrorOnSaveReportException;
use App\Core\Report\Domain\Snapshots\ReportSnapshot;

interface WriteReportRepository
{
    public function ofId(string $reportId): ?DailyReport;

    /**
     * @throws ErrorOnSaveReportException
     */
    public function save(ReportSnapshot $report): void;

    public function exists(string $reportId): bool;

    /**
     * @throws ErrorOnSaveReportException
     */
    public function delete(string $reportId): void;
}
