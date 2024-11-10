<?php

namespace App\Core\Project\Tests\E2E;

use App\Core\Project\Domain\Enums\ProjectMessageEnum;
use App\Core\Project\Tests\Feature\Builder\ProjectSUT;
use App\Core\Shared\Infrastructure\Models\Years;
use App\Core\User\Infrastructure\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectActionTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Years::factory()->create();
    }

    public function test_can_save_project(): void
    {
        $data = [
            'name' => 'Test Project',
            'description' => 'Test Project',
        ];

        $response = $this->actingAs($this->user)->postJson('api/v1/projects', $data);

        $response->assertOk();
        $this->assertTrue($response->json()['isSaved']);
        $this->assertEquals(ProjectMessageEnum::SAVE, $response->json()['message']);
        $this->assertDatabaseHas('projects', $data);

    }

    public function test_can_delete_project(): void
    {
        $sut = ProjectSUT::asSUT()
            ->withDbExistingProject()
            ->build();
        $projectId = $sut->dbProject->id;

        $response = $this->actingAs($this->user)->deleteJson('/api/v1/projects/'.$projectId);

        $response->assertOk();
        $this->assertTrue($response->json()['isDeleted']);
        $this->assertEquals(ProjectMessageEnum::DELETED, $response->json()['message']);
    }
}
