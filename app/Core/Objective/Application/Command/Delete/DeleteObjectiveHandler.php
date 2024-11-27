<?php

namespace App\Core\Objective\Application\Command\Delete;

use App\Core\Objective\Domain\Enums\ObjectiveMessageEnum;
use App\Core\Objective\Domain\Exceptions\ErrorOnSaveObjectiveException;
use App\Core\Objective\Domain\Exceptions\NotFoundObjectiveException;
use App\Core\Objective\Domain\Repository\WriteObjectiveRepository;

final readonly class DeleteObjectiveHandler
{
    public function __construct(private WriteObjectiveRepository $repository) {}

    /**
     * @throws ErrorOnSaveObjectiveException
     * @throws NotFoundObjectiveException
     */
    public function handle(string $objectiveId): DeleteObjectiveResponse
    {
        $res = new DeleteObjectiveResponse;
        $this->checkIfObjectiveExistOrThrowNotFoundException($objectiveId);
        $this->repository->delete($objectiveId);
        $res->isDeleted = true;
        $res->message = ObjectiveMessageEnum::DELETED;

        return $res;
    }

    /**
     * @throws NotFoundObjectiveException
     */
    private function checkIfObjectiveExistOrThrowNotFoundException(string $reportId): void
    {
        if (! $this->repository->exists($reportId)) {
            throw new NotFoundObjectiveException;
        }
    }
}
