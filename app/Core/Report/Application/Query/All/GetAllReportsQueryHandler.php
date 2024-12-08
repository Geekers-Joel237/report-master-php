<?php

namespace App\Core\Report\Application\Query\All;

use App\Core\Report\Domain\Dto\FilterReportParams;
use App\Core\Report\Domain\Repositories\ReadReportRepository;

final readonly class GetAllReportsQueryHandler
{
    public function __construct(
        private ReadReportRepository $repository
    ) {}

    public function handle(FilterReportCommand $command): array
    {
        $params = $this->buildFilterParams($command);

        return $this->repository->filter($params);

    }

    private function buildFilterParams(FilterReportCommand $command): FilterReportParams
    {
        return new FilterReportParams(...(array) $command);
    }
}
