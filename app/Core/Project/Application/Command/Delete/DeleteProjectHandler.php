<?php

namespace App\Core\Project\Application\Command\Delete;

use App\Core\Project\Domain\Entities\Project;
use App\Core\Project\Domain\Enums\ProjectMessageEnum;
use App\Core\Project\Domain\Exceptions\ErrorOnSaveProjectException;
use App\Core\Project\Domain\Exceptions\NotFoundProjectException;
use App\Core\Project\Domain\Repository\WriteProjectRepository;
use Throwable;

final readonly class DeleteProjectHandler
{
    public function __construct(
        private WriteProjectRepository $repository,
    ) {}

    /**
     * @throws ErrorOnSaveProjectException
     * @throws Throwable
     */
    public function handle(string $projectId): DeleteProjectResponse
    {
        $response = new DeleteProjectResponse();

        $existingProject = $this->getProjectIfExistOrThrowNotFoundException($projectId);
        $this->repository->delete($existingProject);

        $response->isDeleted = true;
        $response->message = ProjectMessageEnum::DELETED;

        return $response;
    }

    /**
     * @throws Throwable
     */
    private function getProjectIfExistOrThrowNotFoundException(string $projectId): Project
    {
        $existingProject = $this->repository->ofId($projectId);
        if (is_null($existingProject)) {
            throw new NotFoundProjectException();
        }

        return $existingProject;
    }
}
