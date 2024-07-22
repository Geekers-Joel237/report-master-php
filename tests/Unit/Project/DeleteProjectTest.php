<?php

namespace Project;

use App\Core\Project\Application\Command\Delete\DeleteProjectHandler;
use App\Core\Project\Application\Command\Delete\DeleteProjectResponse;
use App\Core\Project\Domain\Entities\Project;
use App\Core\Project\Domain\Enum\ProjectMessageEnum;
use App\Core\Project\Domain\Exceptions\ErrorOnSaveProjectException;
use App\Core\Project\Domain\Repository\WriteProjectRepository;
use App\Core\Project\Domain\Vo\NameVo;
use App\Core\Shared\Domain\IdGenerator;
use Tests\TestCase;
use Tests\Unit\Project\Repository\InMemoryWriteProjectRepository;
use Tests\Unit\Shared\FixedIdGenerator;
use Throwable;

class DeleteProjectTest extends TestCase
{
    private WriteProjectRepository $repository;

    private IdGenerator $idGenerator;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new InMemoryWriteProjectRepository();
        $this->idGenerator = new FixedIdGenerator();

    }

    /**
     * @return void
     * @throws ErrorOnSaveProjectException
     * @throws Throwable
     */
    public function test_can_delete_project(): void
    {
        $existingProject = Project::create(id: $this->idGenerator->generate(), name: new NameVo('my-project-name'));
        $this->repository->save($existingProject);

        $response = $this->deleteProject($existingProject->id);

        $this->assertTrue($response->isDeleted);
        $this->assertEquals(ProjectMessageEnum::DELETED, $response->message);

        $expectedProject = $this->repository->ofId($existingProject->id);
        $this->assertNull($expectedProject);

    }

    /**
     * @throws ErrorOnSaveProjectException
     * @throws Throwable
     */
    private function deleteProject(string $projectId): DeleteProjectResponse
    {
        return (new DeleteProjectHandler(
            $this->repository
        ))->handle($projectId);
    }
}
