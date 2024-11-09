<?php

namespace App\Core\Report\Tests\Unit;

use App\Core\Project\Domain\Exceptions\ErrorOnSaveProjectException;
use App\Core\Project\Domain\Exceptions\NotFoundProjectException;
use App\Core\Project\Domain\Repositories\WriteProjectRepository;
use App\Core\Project\Tests\Unit\Repositories\InMemoryWriteProjectRepository;
use App\Core\Report\Application\Command\Save\SaveReportHandler;
use App\Core\Report\Domain\Enums\ReportMessageEnum;
use App\Core\Report\Domain\Exceptions\NotFoundReportException;
use App\Core\Report\Domain\Repositories\WriteReportRepository;
use App\Core\Shared\Domain\Exceptions\InvalidCommandException;
use App\Core\Shared\Domain\IdGenerator;
use App\Core\User\Domain\WriteUserRepository;
use DateTimeImmutable;
use Tests\TestCase;
use Tests\Unit\Shared\FixedIdGenerator;

class SaveReportTest extends TestCase
{
    private IdGenerator $idGenerator;

    private WriteReportRepository $reportRepository;

    private WriteProjectRepository $projectRepository;

    private WriteUserRepository $participantRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->idGenerator = new FixedIdGenerator;
        $this->reportRepository = new InMemoryWriteReportRepository;
        $this->projectRepository = new InMemoryWriteProjectRepository;
        $this->participantRepository = new InMemoryParticipantRepository;
    }

    /**
     * @throws ErrorOnSaveProjectException
     * @throws InvalidCommandException
     * @throws NotFoundProjectException
     * @throws NotFoundReportException
     */
    public function test_can_save_report(): void
    {
        $sut = ReportSut::asSUT()
            ->withProject()
            ->build();
        $this->projectRepository->save($sut->project->snapshot());

        $command = SaveReportCommandBuilder::asBuilder()
            ->withProject($sut->project->snapshot()->id)
            ->withTask(
                description: "Lorem Ipsum is simply dummy text of the printing and typesetting industry.
            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
            when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            It has survived not only five centuries, but also the leap into electronic typesetting,
            remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets
            containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
             PageMaker including versions of Lorem Ipsum."
            )
            ->withParticipantIds([])
            ->build();

        $response = (new SaveReportHandler(
            projectRepository: $this->projectRepository,
            idGenerator: $this->idGenerator,
            reportRepository: $this->reportRepository,
            participantRepository: $this->participantRepository,
        ))->handle($command);

        $this->assertTrue($response->isSaved);
        $this->assertEquals(ReportMessageEnum::SAVE, $response->message);
        $this->assertEquals($this->idGenerator->generate(), $response->reportId);

        $expectedReport = $this->reportRepository->ofId($response->reportId);

        $this->assertNotNull($expectedReport);
        $this->assertEquals((new DateTimeImmutable)->format('Y-m-d H:i:s'), $expectedReport->snapshot()->createdAt);
        $this->assertCount(0, $expectedReport->snapshot()->participants);
        $this->assertCount(1, $expectedReport->snapshot()->tasks);
    }

    /**
     * @throws ErrorOnSaveProjectException
     * @throws NotFoundProjectException
     * @throws NotFoundReportException
     * @throws InvalidCommandException
     */
    public function test_can_save_report_with_participants(): void
    {
        $sut = ReportSut::asSUT()
            ->withProject()->withParticipants(['001', '003', '004', '005', '006'])
            ->build();
        $this->projectRepository->save($sut->project->snapshot());
        $this->participantRepository->participantIds = $sut->participants;

        $command = SaveReportCommandBuilder::asBuilder()
            ->withProject($sut->project->snapshot()->id)
            ->withTask(
                description: "Lorem Ipsum is simply dummy text of the printing and typesetting industry.
            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
            when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            It has survived not only five centuries, but also the leap into electronic typesetting,
            remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets
            containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
             PageMaker including versions of Lorem Ipsum."
            )
            ->withParticipantIds(['001', '002', '003'])
            ->build();

        $response = (new SaveReportHandler(
            projectRepository: $this->projectRepository,
            idGenerator: $this->idGenerator,
            reportRepository: $this->reportRepository,
            participantRepository: $this->participantRepository
        ))->handle($command);

        $this->assertTrue($response->isSaved);

        $expectedReport = $this->reportRepository->ofId($response->reportId);

        $this->assertNotNull($expectedReport);
        $this->assertEquals((new DateTimeImmutable)->format('Y-m-d H:i:s'), $expectedReport->snapshot()->createdAt);
        $this->assertCount(2, $expectedReport->snapshot()->participants);
        $this->assertCount(1, $expectedReport->snapshot()->tasks);
    }
}
