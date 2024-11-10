<?php

namespace App\Core\Report\Application\Command\Delete;

use App\Core\Report\Domain\Enums\ReportMessageEnum;
use App\Core\Report\Domain\Exceptions\NotFoundReportException;
use App\Core\Report\Domain\Repositories\WriteReportRepository;

final readonly class DeleteReportHandler
{
    public function __construct(private WriteReportRepository $repository) {}

    /**
     * @throws NotFoundReportException
     */
    public function handle(string $reportId): DeleteReportResponse
    {
        $res = new DeleteReportResponse;
        $this->checkIfReportExistOrThrowNotFoundException($reportId);
        $this->repository->delete($reportId);
        $res->isDeleted = true;
        $res->message = ReportMessageEnum::DELETED;

        return $res;
    }

    /**
     * @throws NotFoundReportException
     */
    private function checkIfReportExistOrThrowNotFoundException(string $reportId): void
    {
        if (! $this->repository->exists($reportId)) {
            throw new NotFoundReportException;
        }
    }
}
