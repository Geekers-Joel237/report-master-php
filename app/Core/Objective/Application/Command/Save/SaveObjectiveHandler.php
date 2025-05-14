<?php

namespace App\Core\Objective\Application\Command\Save;

use App\Core\Objective\Domain\Entities\Objective;
use App\Core\Objective\Domain\Enums\ObjectiveMessageEnum;
use App\Core\Objective\Domain\Exceptions\ErrorOnSaveObjectiveException;
use App\Core\Objective\Domain\Exceptions\NotFoundObjectiveException;
use App\Core\Objective\Domain\Repository\WriteObjectiveRepository;
use App\Core\Project\Domain\Exceptions\NotFoundProjectException;
use App\Core\Project\Domain\Repositories\WriteProjectRepository;
use App\Core\Shared\Domain\Exceptions\InvalidCommandException;
use App\Core\Shared\Domain\IdGenerator;
use App\Core\User\Domain\Repository\WriteUserRepository;

final readonly class SaveObjectiveHandler
{
    public function __construct(
        private WriteProjectRepository $projectRepository,
        private IdGenerator $idGenerator,
        private WriteObjectiveRepository $objectiveRepository,
        private WriteUserRepository $participantRepository,

    ) {}

    /**
     * @throws NotFoundObjectiveException
     * @throws NotFoundProjectException|ErrorOnSaveObjectiveException
     */
    public function handle(SaveObjectiveCommand $command): SaveObjectiveResponse
    {
        $response = new SaveObjectiveResponse;

        $this->checkIfProjectExistOrThrowNotFoundException($command->projectId);
        $participantIds = $this->getExistsParticipants($command->participantIds);
        try {

            if (is_null($command->objectiveId)) {
                $objective = $this->createObjective($command, $participantIds);
                $msg = ObjectiveMessageEnum::SAVE;

            } else {
                $objective = $this->updateExistingObjective($command, $participantIds);
                $msg = ObjectiveMessageEnum::UPDATED;

            }
        } catch (InvalidCommandException $e) {
            $response->message = $e->getMessage();

            return $response;
        }
        $this->objectiveRepository->save($objective->snapshot());

        $response->isSaved = true;
        $response->message = $msg;
        $response->objectiveId = $objective->snapshot()->id;

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
     * @throws InvalidCommandException
     * @throws NotFoundObjectiveException
     */
    private function updateExistingObjective(SaveObjectiveCommand $command, array $participantIds): Objective
    {
        $eObjective = $this->objectiveRepository->ofId($command->objectiveId);
        if (is_null($eObjective)) {
            throw new NotFoundObjectiveException;
        }

        return $eObjective->update(
            $command->tasks,
            $participantIds,
        );
    }

    /**
     * @throws InvalidCommandException
     */
    public function createObjective(SaveObjectiveCommand $command, array $participantIds): Objective
    {
        return Objective::create(
            $command->projectId,
            $command->tasks,
            $participantIds,
            $this->idGenerator->generate(),
            $command->ownerId
        );
    }
}
