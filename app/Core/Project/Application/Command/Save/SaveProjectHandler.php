<?php

namespace App\Core\Project\Application\Command\Save;

use App\Core\Project\Domain\Entities\Project;
use App\Core\Project\Domain\Enums\ProjectMessageEnum;
use App\Core\Project\Domain\Exceptions\ErrorOnSaveProjectException;
use App\Core\Project\Domain\Exceptions\NotFoundProjectException;
use App\Core\Project\Domain\Repositories\WriteProjectRepository;
use App\Core\Project\Domain\Vo\NameVo;
use App\Core\Shared\Domain\IdGenerator;
use Throwable;

final readonly class SaveProjectHandler
{
    public function __construct(
        private WriteProjectRepository $repository,
        private IdGenerator $idGenerator
    ) {}

    /**
     * @throws ErrorOnSaveProjectException
     * @throws Throwable
     */
    public function handle(SaveProjectCommand $command): SaveProjectResponse
    {
        $response = new SaveProjectResponse;

        $name = new NameVo($command->name);
        $id = $this->idGenerator->generate();

        $this->checkIfProjectExistByIdOrThrownNotFoundException($command->projectId);
        $existingProjectByName = $this->repository->ofName($name->value());
        if (! is_null($existingProjectByName)) {
            $project = $this->updateExistingProject($existingProjectByName, $name, $command);
            $response->message = ProjectMessageEnum::UPDATED;
        } else {
            $project = Project::create(
                id: $id,
                name: $name,
                description: $command->description,
                existingId: $command->projectId);
            $response->message = $command->projectId ? ProjectMessageEnum::UPDATED : ProjectMessageEnum::SAVE;
        }

        $this->repository->save($project);

        $response->isSaved = true;
        $response->projectId = $project->id;

        return $response;
    }

    public function updateExistingProject(Project $existingProject, NameVo $name, SaveProjectCommand $command): Project
    {
        return Project::create(
            id: $existingProject->id,
            name: $name,
            description: $command->description,
            existingId: $existingProject->id);
    }

    /**
     * @throws NotFoundProjectException
     * @throws Throwable
     */
    private function checkIfProjectExistByIdOrThrownNotFoundException(?string $projectId): void
    {
        if (is_null($projectId)) {
            return;
        }
        $existingProject = $this->repository->ofId($projectId);
        throw_if(is_null($existingProject), NotFoundProjectException::class);
    }
}
