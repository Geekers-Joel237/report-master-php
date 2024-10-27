<?php

namespace App\Core\Project\Tests\E2E;

use App\Core\Project\Tests\Feature\Builder\ProjectSUT;
use App\Core\User\Infrastructure\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetAllProjetsActionTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_can_get_all_projects()
    {
        ProjectSUT::asSUT()
            ->withExistingProjects(nbProjects: 5)
            ->build();

        $response = $this->actingAs($this->user)->getJson('/api/v1/projects');

        $response->assertOk();
        $this->assertCount(5, $response->json()['projects']);
    }
}
