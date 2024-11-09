<?php

namespace App\Core\Project\Application\Query\All;

use App\Core\Project\Domain\Repositories\ReadProjectRepository;

readonly class GetAllProjectsQueryHandler
{
    public function __construct(
        private ReadProjectRepository $repository
    ) {}

    /**
     * @return ProjectDto[]
     */
    public function handle(FilterProjectCommand $command): array
    {
        return $this->repository->all(year: $command->year, status: $command->status);

    }
}
