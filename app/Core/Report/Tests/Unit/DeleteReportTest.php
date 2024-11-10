<?php

namespace App\Core\Report\Tests\Unit;

use App\Core\Project\Domain\Exceptions\ErrorOnSaveProjectException;
use App\Core\Project\Domain\Repositories\WriteProjectRepository;
use App\Core\Project\Tests\Unit\Repositories\InMemoryWriteProjectRepository;
use App\Core\Report\Application\Command\Delete\DeleteReportHandler;
use App\Core\Report\Domain\Enums\ReportMessageEnum;
use App\Core\Report\Domain\Exceptions\NotFoundReportException;
use App\Core\Report\Domain\Repositories\WriteReportRepository;
use App\Core\Shared\Domain\Exceptions\InvalidCommandException;
use Exception;
use Tests\TestCase;

class DeleteReportTest extends TestCase
{
    private WriteProjectRepository $projectRepository;

    private WriteReportRepository $reportRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->reportRepository = new InMemoryWriteReportRepository;
        $this->projectRepository = new InMemoryWriteProjectRepository;

    }

    /**
     * @throws ErrorOnSaveProjectException
     * @throws InvalidCommandException
     * @throws NotFoundReportException
     * @throws Exception
     */
    public function test_can_delete_existing_report(): void
    {
        $sut = ReportSut::asSUT()
            ->withProject()
            ->withReport()
            ->build();
        $this->projectRepository->save($sut->project->snapshot());
        $this->reportRepository->save($sut->report->snapshot());

        $response = (new DeleteReportHandler(
            repository: $this->reportRepository,
        ))->handle($sut->report->snapshot()->id);

        $this->assertTrue($response->isDeleted);
        $this->assertEquals(ReportMessageEnum::DELETED, $response->message);
        $this->assertNull($this->reportRepository->ofId($sut->report->snapshot()->id));

    }
}
