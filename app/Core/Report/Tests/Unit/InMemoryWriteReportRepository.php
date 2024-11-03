<?php

namespace App\Core\Report\Tests\Unit;

use App\Core\Report\Domain\Entities\Report;
use App\Core\Report\Domain\Repositories\WriteReportRepository;
use App\Core\Report\Domain\Snapshots\ReportSnapshot;
use Exception;

class InMemoryWriteReportRepository implements WriteReportRepository
{
    private array $reportSnapshots = [];

    public function __construct() {}

    public function ofId(string $reportId): ?Report
    {
        return array_key_exists($reportId, $this->reportSnapshots) ? $this->toDomain($this->reportSnapshots[$reportId]) : null;
    }

    /**
     * @throws Exception
     */
    private function toDomain(ReportSnapshot $report): Report
    {
        return Report::createFromAdapter(
            reportId: $report->id,
            projectId: $report->projectId,
            tasks: $report->tasks,
            participants: $report->participants,
            createdAt: $report->createdAt
        );
    }

    public function save(ReportSnapshot $report): void
    {
        $this->reportSnapshots[$report->id] = $report;

    }
}
