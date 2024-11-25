<?php

namespace App\Core\Report\Tests\Unit;

use App\Core\Report\Domain\Entities\DailyReport;
use App\Core\Report\Domain\Repositories\WriteReportRepository;
use App\Core\Report\Domain\Snapshots\ReportSnapshot;
use Exception;

class InMemoryWriteReportRepository implements WriteReportRepository
{
    private array $reportSnapshots = [];

    public function __construct() {}

    /**
     * @throws Exception
     */
    public function ofId(string $reportId): ?DailyReport
    {
        return array_key_exists($reportId, $this->reportSnapshots) ? $this->toDomain($this->reportSnapshots[$reportId]) : null;
    }

    /**
     * @throws Exception
     */
    private function toDomain(ReportSnapshot $report): DailyReport
    {
        return DailyReport::createFromAdapter(
            reportId: $report->id,
            projectId: $report->projectId,
            ownerId: $report->ownerId,
            tasks: $report->tasks,
            participants: $report->participantIds,
            createdAt: $report->createdAt
        );
    }

    public function save(ReportSnapshot $report): void
    {
        $this->reportSnapshots[$report->id] = $report;

    }

    public function exists(string $reportId): bool
    {
        return array_key_exists($reportId, $this->reportSnapshots);
    }

    public function delete(string $reportId): void
    {
        unset($this->reportSnapshots[$reportId]);
    }
}
