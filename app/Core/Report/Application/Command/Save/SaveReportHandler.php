<?php

namespace App\Core\Report\Application\Command\Save;

use App\Core\Project\Domain\Exceptions\NotFoundProjectException;
use App\Core\Project\Domain\Repositories\WriteProjectRepository;
use App\Core\Report\Domain\Entities\DailyReport;
use App\Core\Report\Domain\Enums\ReportMessageEnum;
use App\Core\Report\Domain\Exceptions\ErrorOnSaveReportException;
use App\Core\Report\Domain\Exceptions\NotFoundReportException;
use App\Core\Report\Domain\Repositories\WriteReportRepository;
use App\Core\Shared\Domain\Exceptions\InvalidCommandException;
use App\Core\Shared\Domain\IdGenerator;
use App\Core\User\Domain\Repository\WriteUserRepository;

final readonly class SaveReportHandler
{
    public function __construct(
        private WriteProjectRepository $projectRepository,
        private IdGenerator $idGenerator,
        private WriteReportRepository $reportRepository,
        private WriteUserRepository $participantRepository,

    ) {}

    /**
     * @throws ErrorOnSaveReportException
     * @throws NotFoundProjectException
     * @throws NotFoundReportException
     */
    public function handle(SaveReportCommand $command): SaveReportResponse
    {
        $response = new SaveReportResponse;

        $this->checkIfProjectExistOrThrowNotFoundException($command->projectId);
        $participantIds = $this->getExistsParticipants($command->participantIds);
        try {

            if (is_null($command->reportId)) {
                $report = DailyReport::create(
                    $command->projectId,
                    $command->tasks,
                    $participantIds,
                    $this->idGenerator->generate(),
                    $command->ownerId
                );
                $msg = ReportMessageEnum::SAVE;
            } else {
                $report = $this->updateExistingReport($command, $participantIds);
                $msg = ReportMessageEnum::UPDATED;

            }
        } catch (InvalidCommandException $e) {
            $response->message = $e->getMessage();

            return $response;
        }
        $this->reportRepository->save($report->snapshot());

        $response->isSaved = true;
        $response->message = $msg;
        $response->reportId = $report->snapshot()->id;
        $response->code = 201;

        return $response;
    }

    /**
     * @throws NotFoundProjectException
     */
    private function checkIfProjectExistOrThrowNotFoundException(string $projectId): void
    {
        if (! $this->projectRepository->exists($projectId)) {
            throw new NotFoundProjectException;
        }
    }

    private function getExistsParticipants(array $participantIds): array
    {
        if (empty($participantIds)) {
            return [];
        }

        return $this->participantRepository->allExists($participantIds);
    }

    /**
     * @throws NotFoundReportException
     * @throws InvalidCommandException
     */
    private function updateExistingReport(SaveReportCommand $command, array $participantIds): DailyReport
    {
        $eReport = $this->reportRepository->ofId($command->reportId);
        if (is_null($eReport)) {
            throw new NotFoundReportException;
        }

        return $eReport->update(
            $command->tasks,
            $participantIds,
        );
    }
}
