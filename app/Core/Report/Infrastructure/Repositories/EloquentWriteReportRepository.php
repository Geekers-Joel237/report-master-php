<?php

namespace App\Core\Report\Infrastructure\Repositories;

use App\Core\Report\Domain\Entities\DailyReport;
use App\Core\Report\Domain\Exceptions\ErrorOnSaveReportException;
use App\Core\Report\Domain\Repositories\WriteReportRepository;
use App\Core\Report\Domain\Snapshots\ReportSnapshot;
use App\Core\Report\Infrastructure\Models\Report;
use Exception;
use Throwable;

class EloquentWriteReportRepository implements WriteReportRepository
{
    /**
     * @throws Exception
     */
    public function ofId(string $reportId): ?DailyReport
    {
        return Report::query()->find($reportId)?->toDomain();
    }

    /**
     * @throws ErrorOnSaveReportException
     */
    public function save(ReportSnapshot $report): void
    {
        try {
            $dbReport = Report::query()->updateOrCreate(
                ['id' => $report->id],
                $report->toArray()
            );
            $dbReport->participants()->attach($report->participantIds);
        } catch (Throwable|Exception $e) {
            throw new ErrorOnSaveReportException($e->getMessage());
        }
    }

    public function exists(string $reportId): bool
    {
        return Report::query()->where('id', $reportId)->exists();
    }

    /**
     * @throws ErrorOnSaveReportException
     */
    public function delete(string $reportId): void
    {
        try {
            $eReport = Report::query()->find($reportId);
            $eReport->participants()->detach();
            $eReport->softDelete();
        } catch (Throwable|Exception $e) {
            throw new ErrorOnSaveReportException($e->getMessage());
        }
    }
}
