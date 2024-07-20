<?php

namespace App\Core\Application\Command\Project\Save;

use App\Core\Domain\Entities\Project;
use App\Core\Domain\Exceptions\NotFoundProjectException;
use App\Core\Domain\Repository\Project\WriteProjectRepository;
use App\Core\Domain\Shared\IdGenerator;
use App\Core\Domain\Vo\NameVo;
use Throwable;

readonly class SaveProjectHandler
{
    public function __construct(
        private WriteProjectRepository $repository,
        private IdGenerator $idGenerator
    ) {}

    /**
     * @throws Throwable
     */
    public function handle(SaveProjectCommand $command): SaveProjectResponse
    {
        $response = new SaveProjectResponse();

        $name = new NameVo($command->name);
        $id = $this->idGenerator->generate();

        $this->checkIfProjectExistByIdOrThrownNotFoundException($command->id);
        $existingProject = $this->repository->ofName($name->value());
        if (! is_null($existingProject)) {
            $project = $this->updateExistingProject($existingProject, $name, $command);
        } else {
            $project = Project::create(
                id: $id,
                name: $command->name,
                description: $command->description,
                existingId: $command->id);
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
            name: $name->value(),
            description: $command->description,
            existingId: $existingProject->id);
    }

    /**
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
