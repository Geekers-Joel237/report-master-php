<?php

namespace App\Core\Project\Application\Command\UpdateStatus;

use App\Core\Project\Domain\Entities\Project;
use App\Core\Project\Domain\Enums\ProjectMessageEnum;
use App\Core\Project\Domain\Exceptions\NotFoundProjectException;
use App\Core\Project\Domain\Repositories\WriteProjectRepository;
use App\Core\Shared\Domain\Exceptions\InvalidCommandException;

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
        $response = new UpdateProjectStatusResponse;

        $existingProject = $this->getProjectIfExistOrThrowNotFoundException($command->projectId);
        try {
            $existingProject->updateStatus($command->status);
        } catch (InvalidCommandException $e) {
            $response->message = $e->getMessage();

            return $response;
        }

        $this->repository->update($existingProject->snapshot());
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
