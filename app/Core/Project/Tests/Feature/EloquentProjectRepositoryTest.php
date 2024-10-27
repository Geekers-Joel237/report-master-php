<?php

namespace App\Core\Project\Tests\Feature;

use App\Core\Project\Domain\Entities\Project;
use App\Core\Project\Domain\Exceptions\ErrorOnSaveProjectException;
use App\Core\Project\Domain\Repositories\WriteProjectRepository;
use App\Core\Project\Infrastructure\Repositories\EloquentWriteProjectRepository;
use App\Core\Project\Tests\Feature\Builder\ProjectSUT;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EloquentProjectRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private WriteProjectRepository $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new EloquentWriteProjectRepository;
    }

    /**
     * @return void
     */
    public function test_can_get_existing_project()
    {
        $sut = ProjectSUT::asSUT()
            ->withDbExistingProject()
            ->build();

        $dbProject = $this->repository->ofId($sut->dbProject->id);

        $this->assertNotNull($dbProject);
        $this->assertInstanceOf(Project::class, $dbProject);
    }

    /**
     * @throws ErrorOnSaveProjectException
     */
    public function test_can_save_project()
    {
        $sut = ProjectSUT::asSUT()
            ->withExistingProject()
            ->build();
        $this->repository->save($sut->project->snapshot());

        $dbProject = $this->repository->ofId($sut->project->snapshot()->id);
        $this->assertNotNull($dbProject);
        $this->assertEquals($dbProject->snapshot(), $sut->project->snapshot());
    }

    /**
     * @throws ErrorOnSaveProjectException
     */
    public function test_can_delete_project()
    {
        $sut = ProjectSUT::asSUT()
            ->withExistingProject()
            ->build();
        $this->repository->save($sut->project->snapshot());
        $dbProject = $this->repository->ofId($sut->project->snapshot()->id);
        $this->assertNotNull($dbProject);

        $this->repository->delete($sut->project->snapshot()->id);
        $dbProject = $this->repository->ofId($sut->project->snapshot()->id);

        $this->assertNull($dbProject);
    }
}
