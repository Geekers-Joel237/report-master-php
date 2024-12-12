<?php

namespace App\Core\Objective\Application\Query\All;

use App\Core\Objective\Domain\Dto\FilterObjectiveParams;
use App\Core\Objective\Domain\Repository\ReadObjectiveRepository;

readonly class GetAllObjectivesQueryHandler
{
    public function __construct(
        private ReadObjectiveRepository $repository
    ) {}

    public function handle(FilterObjectiveCommand $command): array
    {
        $params = $this->buildFilterParams($command);

        return $this->repository->filter($params);
    }

    private function buildFilterParams(FilterObjectiveCommand $command): FilterObjectiveParams
    {
        return new FilterObjectiveParams(...(array) $command);
    }
}
