<?php

namespace App\Core\Application\Command\Project\Save;

use App\Core\Domain\Entities\Project;
use App\Core\Domain\Repository\Project\WriteProjectRepository;
use App\Core\Domain\Shared\IdGenerator;

readonly class SaveProjectHandler
{
    public function __construct(
        private WriteProjectRepository $repository,
        private IdGenerator $idGenerator
    ) {}

    public function handle(SaveProjectCommand $command): SaveProjectResponse
    {
        $response = new SaveProjectResponse();

        $id = $this->idGenerator->generate();
        $project = Project::create($id, $command->name, $command->description, $command->id);
        $this->repository->create($project);

        $response->isSaved = true;
        $response->projectId = $project->id;

        return $response;
    }
}
