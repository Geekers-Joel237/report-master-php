<?php

namespace App\Core\Project\Tests\Unit;

use App\Core\Project\Application\Command\Save\SaveProjectCommand;
use App\Core\Project\Application\Command\Save\SaveProjectHandler;
use App\Core\Project\Application\Command\Save\SaveProjectResponse;
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
use Throwable;

class SaveProjectTest extends TestCase
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
     * @throws Throwable
     */
    public function test_can_create_project(): void
    {
        //Given
        $command = new SaveProjectCommand(
            name: 'my-project-name',
            description: 'my-project-description',
        );

        //when
        $response = $this->saveProject($command);

        //then
        $this->assertTrue($response->isSaved);
        $this->assertEquals(ProjectMessageEnum::SAVE, $response->message);
        $this->assertEquals($this->idGenerator->generate(), $response->projectId);

        $expectedProject = $this->repository->ofId($response->projectId);

        $this->assertNotNull($expectedProject);
        $this->assertEquals($command->name, $expectedProject->snapshot()->name);
        $this->assertEquals($command->description, $expectedProject->snapshot()->description);
        $this->assertEquals(ProjectStatusEnum::Started->value, $expectedProject->snapshot()->status);
        $this->assertEquals((new DateTimeImmutable)->format('Y-m-d H:i:s'), $expectedProject->snapshot()->createdAt);
    }

    /**
     * @throws Throwable
     */
    public function saveProject(SaveProjectCommand $command): SaveProjectResponse
    {
        $handler = new SaveProjectHandler($this->repository, $this->idGenerator);

        return $handler->handle($command);
    }

    /**
     * @throws Throwable
     */
    public function test_can_update_project(): void
    {
        $existingProject = Project::create(id: $this->idGenerator->generate(), name: new NameVo('my-project-name'));
        $this->repository->save($existingProject);

        $command = new SaveProjectCommand(
            name: 'my-project-name-modified', description: 'my-project-description', projectId: $existingProject->snapshot()->id
        );
        $response = $this->saveProject($command);

        $this->assertTrue($response->isSaved);
        $this->assertEquals(ProjectMessageEnum::UPDATED, $response->message);
        $this->assertEquals($command->projectId, $response->projectId);

        $expectedProject = $this->repository->ofId($response->projectId);

        $this->assertNotNull($expectedProject);
        $this->assertEquals($command->name, $expectedProject->snapshot()->name);
        $this->assertEquals($command->description, $expectedProject->snapshot()->description);
        $this->assertEquals((new DateTimeImmutable)->format('Y-m-d H:i:s'), $expectedProject->snapshot()->updatedAt);
    }

    /**
     * @throws Throwable
     */
    public function test_save_project_with_existing_name_like(): void
    {
        $existingProject = Project::create(id: $this->idGenerator->generate(), name: new NameVo('my-project-name'));
        $this->repository->save($existingProject);

        $command = new SaveProjectCommand(
            name: ' My-Project-Name ', description: 'my-project-description'
        );
        $response = $this->saveProject($command);

        $this->assertTrue($response->isSaved);
        $this->assertEquals($existingProject->snapshot()->id, $response->projectId);

        $expectedProject = $this->repository->ofId($response->projectId);

        $this->assertNotNull($expectedProject);
        $this->assertEquals($existingProject->snapshot()->name, $expectedProject->snapshot()->name);
        $this->assertEquals($command->description, $expectedProject->snapshot()->description);
        $this->assertEquals((new DateTimeImmutable)->format('Y-m-d H:i:s'), $expectedProject->snapshot()->updatedAt);

    }

    /**
     * @throws Throwable
     * @throws ErrorOnSaveProjectException
     */
    public function test_can_thrown_not_found_exception_when_update_not_existing_project(): void
    {
        $existingProject = Project::create(id: $this->idGenerator->generate(), name: new NameVo('my-project-name'));

        $this->repository->save($existingProject);

        $command = new SaveProjectCommand(
            name: ' My-Project-Name ', description: 'my-project-description', projectId: 'not-existing-project'
        );

        $this->expectException(NotFoundProjectException::class);
        $this->saveProject($command);

    }
}
