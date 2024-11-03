<?php

namespace App\Core\Project\Application\Command\Save;

use App\Core\Project\Domain\Entities\Project;
use App\Core\Project\Domain\Enums\ProjectMessageEnum;
use App\Core\Project\Domain\Exceptions\AlreadyExistsProjectWithSameNameException;
use App\Core\Project\Domain\Exceptions\ErrorOnSaveProjectException;
use App\Core\Project\Domain\Exceptions\NotFoundProjectException;
use App\Core\Project\Domain\Repositories\WriteProjectRepository;
use App\Core\Project\Domain\Vo\NameVo;
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
     */
    public function handle(SaveProjectCommand $command): SaveProjectResponse
    {
        $response = new SaveProjectResponse;

        $name = new NameVo($command->name);
        $nameSlug = $this->slugHelper->slugify($name->value());
        $existingProjectByName = $this->repository->ofSlug($nameSlug);

        if ($command->projectId) {
            $project = $this->getProjectIfExistByIdOrThrownNotFoundException($command->projectId);
            if ($existingProjectByName?->snapshot()->slug === $nameSlug) {
                throw new AlreadyExistsProjectWithSameNameException(ProjectMessageEnum::ALREADY_EXIST_PROJECT_WITH_SAME_NAME);
            }
            $project = $project->update($name, $command->description);
            $message = ProjectMessageEnum::UPDATED;

        } else {
            if ($existingProjectByName) {
                $project = $existingProjectByName->update($name, $command->description);
                $message = ProjectMessageEnum::UPDATED;
            } else {
                $id = $this->idGenerator->generate();
                $project = Project::create(id: $id, name: $name, slug: $nameSlug, description: $command->description);
                $message = ProjectMessageEnum::SAVE;
            }
        }

        $this->repository->save($project->snapshot());

        $response->isSaved = true;
        $response->projectId = $project->snapshot()->id;
        $response->message = $message;

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
}
