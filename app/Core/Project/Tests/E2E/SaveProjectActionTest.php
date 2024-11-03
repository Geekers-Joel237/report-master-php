<?php

namespace App\Core\Project\Tests\E2E;

use App\Core\Shared\Infrastructure\Models\Years;
use App\Core\User\Infrastructure\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SaveProjectActionTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Years::factory()->create();
    }

    public function test_can_save_project()
    {
        $data = [
            'name' => 'Test Project',
            'description' => 'Test Project',
        ];

        $response = $this->actingAs($this->user)->post('api/v1/projects', $data);

        $response->assertOk();
        $this->assertDatabaseHas('projects', $data);

    }
}
