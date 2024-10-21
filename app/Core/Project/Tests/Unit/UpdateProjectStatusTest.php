<?php

namespace App\Core\Project\Tests\Unit;

use App\Core\Project\Application\Command\UpdateStatus\UpdateProjectStatusCommand;
use App\Core\Project\Application\Command\UpdateStatus\UpdateProjectStatusHandler;
use App\Core\Project\Application\Command\UpdateStatus\UpdateProjectStatusResponse;
use App\Core\Project\Domain\Entities\Project;
use App\Core\Project\Domain\Enums\ProjectMessageEnum;
use App\Core\Project\Domain\Enums\ProjectStatusEnum;
use App\Core\Project\Domain\Exceptions\ErrorOnSaveProjectException;
use App\Core\Project\Domain\Exceptions\NotFoundProjectException;
use App\Core\Project\Domain\Repositories\WriteProjectRepository;
use App\Core\Project\Domain\Vo\NameVo;
use App\Core\Project\Tests\Unit\Repositories\InMemoryWriteProjectRepository;
use App\Core\Shared\Domain\IdGenerator;
use DateTimeImmutable;
use Tests\TestCase;
use Tests\Unit\Shared\FixedIdGenerator;

class UpdateProjectStatusTest extends TestCase
{
    private WriteProjectRepository $repository;

    private IdGenerator $idGenerator;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new InMemoryWriteProjectRepository;
        $this->idGenerator = new FixedIdGenerator;
    }

    /**
     * @throws ErrorOnSaveProjectException|NotFoundProjectException
     */
    public function test_can_update_project_status(): void
    {
        $existingProject = Project::create(id: $this->idGenerator->generate(), name: new NameVo('my-project-name'));
        $this->repository->save($existingProject);

        $command = new UpdateProjectStatusCommand(
            projectId: $existingProject->id,
            status: ProjectStatusEnum::Completed->value
        );
        $response = $this->updateProjectStatus($command);

        $this->assertTrue($response->isSaved);
        $this->assertEquals(ProjectMessageEnum::UPDATED, $response->message);
        $this->assertEquals($command->projectId, $response->projectId);

        $expectedProject = $this->repository->ofId($response->projectId);
        $this->assertNotNull($expectedProject);
        $this->assertEquals($command->status, $expectedProject->status()->value);
        $this->assertEquals((new DateTimeImmutable)->format('Y-m-d'), $expectedProject->updatedAt()?->format('Y-m-d'));
    }

    /**
     * @throws NotFoundProjectException
     */
    private function updateProjectStatus(UpdateProjectStatusCommand $command): UpdateProjectStatusResponse
    {
        return (new UpdateProjectStatusHandler($this->repository))->handle($command);
    }
}
