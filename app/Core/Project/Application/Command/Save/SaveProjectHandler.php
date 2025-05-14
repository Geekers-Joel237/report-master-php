<?php

namespace App\Core\Project\Application\Command\Save;

use App\Core\Project\Domain\Entities\Project;
use App\Core\Project\Domain\Enums\ProjectMessageEnum;
use App\Core\Project\Domain\Exceptions\AlreadyExistsProjectWithSameNameException;
use App\Core\Project\Domain\Exceptions\ErrorOnSaveProjectException;
use App\Core\Project\Domain\Exceptions\NotFoundProjectException;
use App\Core\Project\Domain\Repositories\WriteProjectRepository;
use App\Core\Project\Domain\Vo\NameVo;
use App\Core\Shared\Domain\Exceptions\InvalidCommandException;
use App\Core\Shared\Domain\IdGenerator;
use App\Core\Shared\Domain\SlugHelper;

final readonly class SaveProjectHandler
{
    public function __construct(
        private WriteProjectRepository $repository,
        private IdGenerator $idGenerator,
        private SlugHelper $slugHelper
    ) {}

    /**
     * @throws ErrorOnSaveProjectException
     * @throws NotFoundProjectException
     * @throws AlreadyExistsProjectWithSameNameException
     * @throws InvalidCommandException
     */
    public function handle(SaveProjectCommand $command): SaveProjectResponse
    {
        $response = new SaveProjectResponse;

        $name = new NameVo($command->name);
        $nameSlug = $this->slugHelper->slugify($name->value());
        $existingProjectByName = $this->repository->ofSlug($nameSlug);

        if ($command->projectId) {
            $project = $this->getProjectIfExistByIdOrThrownNotFoundException($command->projectId);
            if ($existingProjectByName && $existingProjectByName->snapshot()->id !== $command->projectId) {
                throw new AlreadyExistsProjectWithSameNameException(ProjectMessageEnum::ALREADY_EXIST_PROJECT_WITH_SAME_NAME);
            }
            [$project, $message] = $this->attemptToUpdateProject($project, $name, $command);

        } else {
            if ($existingProjectByName) {
                [$project, $message] = $this->attemptToCreateProjectWithNameLikeAnExistingProject($existingProjectByName, $name, $command);

            } else {
                $id = $this->idGenerator->generate();
                $project = Project::create(id: $id, name: $name, slug: $nameSlug, description: $command->description);
                $message = ProjectMessageEnum::SAVE;
                $this->repository->create($project->snapshot());

            }
        }

        $response->isSaved = true;
        $response->projectId = $project->snapshot()->id;
        $response->message = $message;
        $response->code = 201;

        return $response;
    }

    /**
     * @throws NotFoundProjectException
     */
    private function getProjectIfExistByIdOrThrownNotFoundException(string $projectId): Project
    {
        $existingProject = $this->repository->ofId($projectId);
        if (is_null($existingProject)) {
            throw new NotFoundProjectException;
        }

        return $existingProject;
    }

    public function attemptToUpdateProject(Project $project, NameVo $name, SaveProjectCommand $command): array
    {
        $project = $project->update($name, $command->description);
        $message = ProjectMessageEnum::UPDATED;
        $this->repository->update($project->snapshot());

        return [$project, $message];
    }

    public function attemptToCreateProjectWithNameLikeAnExistingProject(Project $existingProjectByName, NameVo $name, SaveProjectCommand $command): array
    {
        $project = $existingProjectByName->update($name, $command->description);
        $message = ProjectMessageEnum::UPDATED;
        $this->repository->update($project->snapshot());

        return [$project, $message];
    }
}
