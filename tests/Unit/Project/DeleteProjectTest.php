<?php

namespace Project;

use App\Core\Project\Application\Command\Delete\DeleteProjectHandler;
use App\Core\Project\Application\Command\Delete\DeleteProjectResponse;
use App\Core\Project\Domain\Entities\Project;
use App\Core\Project\Domain\Enums\ProjectMessageEnum;
use App\Core\Project\Domain\Exceptions\ErrorOnSaveProjectException;
use App\Core\Project\Domain\Repositories\WriteProjectRepository;
use App\Core\Project\Domain\Vo\NameVo;
use App\Core\Shared\Domain\IdGenerator;
use Tests\TestCase;
use Tests\Unit\Project\Repositories\InMemoryWriteProjectRepository;
use Tests\Unit\Shared\FixedIdGenerator;
use Throwable;

class DeleteProjectTest extends TestCase
{
    private WriteProjectRepository $writeProjectRepository;

    private IdGenerator $idGenerator;

    public function setUp(): void
    {
        parent::setUp();
        $this->writeProjectRepository = new InMemoryWriteProjectRepository();
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
        $this->writeProjectRepository->save($existingProject);

        $response = $this->deleteProject($existingProject->id);

        $this->assertTrue($response->isDeleted);
        $this->assertEquals(ProjectMessageEnum::DELETED, $response->message);

        $expectedProject = $this->writeProjectRepository->ofId($existingProject->id);
        $this->assertNull($expectedProject);

    }

    /**
     * @throws ErrorOnSaveProjectException
     * @throws Throwable
     */
    private function deleteProject(string $projectId): DeleteProjectResponse
    {
        return (new DeleteProjectHandler(
            $this->writeProjectRepository
        ))->handle($projectId);
    }
}
