<?php

namespace App\Core\Objective\Domain\Repository;

use App\Core\Objective\Domain\Entities\Objective;
use App\Core\Objective\Domain\Exceptions\ErrorOnSaveObjectiveException;
use App\Core\Objective\Domain\Snapshot\ObjectiveSnapshot;

interface WriteObjectiveRepository
{
    /**
     * @throws ErrorOnSaveObjectiveException
     */
    public function delete(string $objectiveId): void;

    public function exists(string $objectiveId): bool;

    public function ofId(?string $objectiveId): ?Objective;

    /**
     * @throws ErrorOnSaveObjectiveException
     */
    public function save(ObjectiveSnapshot $objective): void;
}
