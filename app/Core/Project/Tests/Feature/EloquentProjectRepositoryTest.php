<?php

namespace App\Core\Project\Tests\Feature;

use App\Core\Project\Domain\Entities\Project;
use App\Core\Project\Domain\Repositories\WriteProjectRepository;
use App\Core\Project\Infrastructure\Repository\EloquentProjectRepository;
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
        $this->repository = new EloquentProjectRepository;
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
}
