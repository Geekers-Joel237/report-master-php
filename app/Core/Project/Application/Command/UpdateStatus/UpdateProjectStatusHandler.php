<?php

namespace App\Core\Project\Application\Command\UpdateStatus;

use App\Core\Project\Domain\Entities\Project;
use App\Core\Project\Domain\Enums\ProjectMessageEnum;
use App\Core\Project\Domain\Exceptions\NotFoundProjectException;
use App\Core\Project\Domain\Repository\WriteProjectRepository;

final readonly class UpdateProjectStatusHandler
{
    public function __construct(
        private WriteProjectRepository $repository
    ) {}

    /**
     * @throws NotFoundProjectException
     */
    public function handle(UpdateProjectStatusCommand $command): UpdateProjectStatusResponse
    {
        $response = new UpdateProjectStatusResponse();

        $existingProject = $this->getProjectIfExistOrThrowNotFoundException($command->projectId);
        $existingProject->updateStatus($command->status);

        $response->isSaved = true;
        $response->projectId = $existingProject->id;
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
            throw new NotFoundProjectException();
        }

        return $existingProject;
    }
}
