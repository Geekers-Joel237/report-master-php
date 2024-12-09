<?php

namespace App\Core\Report\Tests\E2E;

use App\Core\Report\Domain\Enums\ReportMessageEnum;
use App\Core\Report\Infrastructure\Models\Report;
use App\Core\User\Infrastructure\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Random\RandomException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class ReportActionTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * @throws RandomException
     */
    public function test_can_save_report(): void
    {
        $sut = ReportSUT::asSUT()
            ->withProject()
            ->withTasks(2)
            ->withParticipants(1)
            ->build();
        $data = [
            'tasks' => $sut->tasks,
            'participantIds' => $sut->participants,
            'projectId' => $sut->project->id,
        ];
        $response = $this->actingAs($this->user)->postJson('api/v1/reports', $data);

        $response->assertStatus(ResponseAlias::HTTP_CREATED);
        $this->assertTrue($response->json()['data']['isSaved']);
        $this->assertEquals(ReportMessageEnum::SAVE, $response->json()['data']['message']);
        $this->assertCount(1, Report::all());
    }

    public function test_can_get_all_reports_filter_by_project(): void
    {
        $sut = ReportSUT::asSUT()
            ->withProject()
            ->withReports(5)
            ->build();

        $projectId = $sut->project->id;
        $response = $this->actingAs($this->user)->getJson('/api/v1/reports'.'?projectId='.$projectId);

        $response->assertOk();
        $this->assertIsArray($response->json()['data']['reports']);
        $this->assertEquals(5, $response->json()['data']['total']);
        $this->assertCount(5, $response->json()['data']['reports']);

    }
}
