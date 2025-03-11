<?php

namespace App\Core\Project\Tests\Feature;

use App\Core\Project\Domain\Entities\Project;
use App\Core\Project\Domain\Exceptions\ErrorOnSaveProjectException;
use App\Core\Project\Domain\Repositories\WriteProjectRepository;
use App\Core\Project\Infrastructure\Models\Project as ProjectModel;
use App\Core\Project\Infrastructure\Repositories\EloquentWriteProjectRepository;
use App\Core\Project\Tests\Feature\Builder\ProjectSUT;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EloquentProjectRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private WriteProjectRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new EloquentWriteProjectRepository;
    }

    /**
     * @return void
     *
     * @throws Exception
     */
    public function test_can_get_existing_project()
    {
        $sut = ProjectSUT::asSUT()
            ->withDbExistingProject()
            ->build();

        $this->assertInstanceOf(expected: ProjectModel::class, actual: $sut->dbProject);
        $dbProject = $this->repository->ofId($sut->dbProject->id);

        $this->assertNotNull($dbProject);
        $this->assertInstanceOf(Project::class, $dbProject);
    }

    /**
     * @throws ErrorOnSaveProjectException
     * @throws Exception
     */
    public function test_can_save_project()
    {
        $sut = ProjectSUT::asSUT()
            ->withExistingProject()
            ->build();
        $this->assertInstanceOf(Project::class, $sut->project);
        $this->repository->create($sut->project->snapshot());

        $dbProject = $this->repository->ofId($sut->project->snapshot()->id);
        $this->assertNotNull($dbProject);
        $this->assertEquals($dbProject->snapshot(), $sut->project->snapshot());
    }

    /**
     * @throws ErrorOnSaveProjectException
     * @throws Exception
     */
    public function test_can_delete_project()
    {
        $sut = ProjectSUT::asSUT()
            ->withExistingProject()
            ->build();
        $this->assertNotNull($sut->project);
        $this->repository->create($sut->project->snapshot());
        $dbProject = $this->repository->ofId($sut->project->snapshot()->id);
        $this->assertNotNull($dbProject);

        $this->repository->delete($sut->project->snapshot()->id);
        $dbProject = $this->repository->ofId($sut->project->snapshot()->id);

        $this->assertNull($dbProject);
    }
}
