<?php

namespace App\Core\Project\Application\Command\UpdateStatus;

use App\Core\Project\Domain\Entities\Project;
use App\Core\Project\Domain\Enums\ProjectMessageEnum;
use App\Core\Project\Domain\Exceptions\ErrorOnSaveProjectException;
use App\Core\Project\Domain\Exceptions\NotFoundProjectException;
use App\Core\Project\Domain\Repositories\WriteProjectRepository;

final readonly class UpdateProjectStatusHandler
{
    public function __construct(
        private WriteProjectRepository $repository
    ) {}

    /**
     * @throws ErrorOnSaveProjectException
     * @throws NotFoundProjectException
     */
    public function handle(UpdateProjectStatusCommand $command): UpdateProjectStatusResponse
    {
        $response = new UpdateProjectStatusResponse;

        $existingProject = $this->getProjectIfExistOrThrowNotFoundException($command->projectId);
        $existingProject->updateStatus($command->status);

        $this->repository->save($existingProject->snapshot());
        $response->isSaved = true;
        $response->projectId = $existingProject->snapshot()->id;
        $response->message = ProjectMessageEnum::UPDATED;

        return $response;
    }

    /**
     * @throws NotFoundProjectException
     */
    private function getProjectIfExistOrThrowNotFoundException(string $projectId): Project
    {
        $existingProject = $this->repository->ofId($projectId);
        if (is_null($existingProject)) {
            throw new NotFoundProjectException;
        }

        return $existingProject;
    }
}
