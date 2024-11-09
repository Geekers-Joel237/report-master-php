<?php

namespace App\Core\Report\Application\Command\Save;

use App\Core\Project\Domain\Exceptions\NotFoundProjectException;
use App\Core\Project\Domain\Repositories\WriteProjectRepository;
use App\Core\Report\Domain\Entities\Report;
use App\Core\Report\Domain\Enums\ReportMessageEnum;
use App\Core\Report\Domain\Exceptions\NotFoundReportException;
use App\Core\Report\Domain\Repositories\WriteReportRepository;
use App\Core\Shared\Domain\Exceptions\InvalidCommandException;
use App\Core\Shared\Domain\IdGenerator;
use App\Core\User\Domain\WriteUserRepository;

final readonly class SaveReportHandler
{
    public function __construct(
        private WriteProjectRepository $projectRepository,
        private IdGenerator $idGenerator,
        private WriteReportRepository $reportRepository,
        private WriteUserRepository $participantRepository,

    ) {}

    /**
     * @throws NotFoundProjectException
     * @throws NotFoundReportException
     * @throws InvalidCommandException
     */
    public function handle(SaveReportCommand $command): SaveReportResponse
    {
        $response = new SaveReportResponse;

        $this->checkIfProjectExistOrThrowNotFoundException($command->projectId);
        $participantIds = $this->getExistsParticipants($command->participantIds);

        if (is_null($command->reportId)) {
            $report = Report::create(
                $command->projectId,
                $command->tasks,
                $participantIds,
                $this->idGenerator->generate(),
            );
            $msg = ReportMessageEnum::SAVE;
        } else {
            $report = $this->updateExistingReport($command, $participantIds);
            $msg = ReportMessageEnum::UPDATED;

        }

        $this->reportRepository->save($report->snapshot());

        $response->isSaved = true;
        $response->message = $msg;
        $response->reportId = $report->snapshot()->id;

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
    private function updateExistingReport(SaveReportCommand $command, array $participantIds): Report
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
