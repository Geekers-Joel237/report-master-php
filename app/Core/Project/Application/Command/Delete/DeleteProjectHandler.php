<?php

namespace App\Core\Project\Application\Command\Delete;

use App\Core\Project\Domain\Enums\ProjectMessageEnum;
use App\Core\Project\Domain\Exceptions\ErrorOnSaveProjectException;
use App\Core\Project\Domain\Exceptions\NotFoundProjectException;
use App\Core\Project\Domain\Repositories\WriteProjectRepository;

final readonly class DeleteProjectHandler
{
    public function __construct(
        private WriteProjectRepository $repository,
    ) {}

    /**
     * @throws ErrorOnSaveProjectException
     * @throws NotFoundProjectException
     */
    public function handle(string $projectId): DeleteProjectResponse
    {
        $response = new DeleteProjectResponse;

        $this->checkIfProjectExistOrThrowNotFoundException($projectId);
        $this->repository->delete($projectId);

        $response->isDeleted = true;
        $response->message = ProjectMessageEnum::DELETED;
        $response->code = 200;

        return $response;
    }

    /**
     * @throws NotFoundProjectException
     */
    private function checkIfProjectExistOrThrowNotFoundException(string $projectId): void
    {
        if (! $this->repository->exists($projectId)) {
            throw new NotFoundProjectException;
        }
    }
}
