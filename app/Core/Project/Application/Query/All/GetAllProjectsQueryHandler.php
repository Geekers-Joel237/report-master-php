<?php

namespace App\Core\Project\Application\Query\All;

use App\Core\Project\Domain\Repositories\ReadProjectRepository;

readonly class GetAllProjectsQueryHandler
{
    public function __construct(
        private ReadProjectRepository $repository
    ) {}

    public function handle(): array
    {
        return $this->repository->all();

    }
}
