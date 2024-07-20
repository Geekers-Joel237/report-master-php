<?php

namespace Tests\Unit\Project;

use App\Core\Application\Command\Project\Save\SaveProjectCommand;
use App\Core\Application\Command\Project\Save\SaveProjectHandler;
use App\Core\Application\Command\Project\Save\SaveProjectResponse;
use App\Core\Domain\Entities\Project;
use App\Core\Domain\Exceptions\NotFoundProjectException;
use App\Core\Domain\Repository\Project\WriteProjectRepository;
use App\Core\Domain\Shared\IdGenerator;
use DateTimeImmutable;
use Tests\TestCase;
use Tests\Unit\Project\Repository\InMemoryWriteProjectRepository;
use Tests\Unit\Shared\FixedIdGenerator;

class SaveProjectTest extends TestCase
{
    private WriteProjectRepository $repository;

    private IdGenerator $idGenerator;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new InMemoryWriteProjectRepository();
        $this->idGenerator = new FixedIdGenerator();
    }

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
        $this->assertEquals($this->idGenerator->generate(), $response->projectId);

        $expectedProject = $this->repository->ofId($response->projectId);
        $this->assertEquals($command->name, $expectedProject->name);
        $this->assertEquals($command->description, $expectedProject->description);
        $this->assertEquals((new DateTimeImmutable())->format('Y-m-d'), $expectedProject->createdAt()->format('Y-m-d'));
    }

    public function test_can_update_project(): void
    {
        $existingProject = Project::create(id: $this->idGenerator->generate(), name: 'my-project-name');
        $this->repository->save($existingProject);

        $command = new SaveProjectCommand(
            name: 'my-project-name-modified', description: 'my-project-description', id: $existingProject->id
        );
        $response = $this->saveProject($command);

        $this->assertTrue($response->isSaved);
        $this->assertEquals($command->id, $response->projectId);

        $expectedProject = $this->repository->ofId($response->projectId);
        $this->assertEquals($command->name, $expectedProject->name);
        $this->assertEquals($command->description, $expectedProject->description);
        $this->assertEquals((new DateTimeImmutable())->format('Y-m-d'), $expectedProject->updatedAt()->format('Y-m-d'));
    }

    public function test_save_project_with_existing_name_like(): void
    {
        $existingProject = Project::create(id: $this->idGenerator->generate(), name: 'my-project-name');
        $this->repository->save($existingProject);

        $command = new SaveProjectCommand(
            name: ' My-Project-Name ', description: 'my-project-description'
        );
        $response = $this->saveProject($command);

        $this->assertTrue($response->isSaved);
        $this->assertEquals($existingProject->id, $response->projectId);

        $expectedProject = $this->repository->ofId($response->projectId);
        $this->assertEquals($existingProject->name, $expectedProject->name);
        $this->assertEquals($command->description, $expectedProject->description);
        $this->assertEquals((new DateTimeImmutable())->format('Y-m-d'), $expectedProject->updatedAt()->format('Y-m-d'));

    }

    public function test_can_thrown_not_found_exception_when_update_not_existing_project(): void
    {
        $existingProject = Project::create(id: $this->idGenerator->generate(), name: 'my-project-name');
        $this->repository->save($existingProject);

        $command = new SaveProjectCommand(
            name: ' My-Project-Name ', description: 'my-project-description', id: 'not-existing-project'
        );

        $this->expectException(NotFoundProjectException::class);
        $this->saveProject($command);

    }

    public function saveProject(SaveProjectCommand $command): SaveProjectResponse
    {
        $handler = new SaveProjectHandler($this->repository, $this->idGenerator);

        return $handler->handle($command);
    }
}
