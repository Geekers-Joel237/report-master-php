<?php

namespace App\Core\Objective\Infrastructure\Repository;

use App\Core\Objective\Domain\Entities\Objective;
use App\Core\Objective\Domain\Exceptions\ErrorOnSaveObjectiveException;
use App\Core\Objective\Domain\Repository\WriteObjectiveRepository;
use App\Core\Objective\Domain\Snapshot\ObjectiveSnapshot;
use App\Core\Objective\Infrastructure\Model\Objective as ObjectiveModel;
use Exception;
use Throwable;

class EloquentWriteObjectiveRepository implements WriteObjectiveRepository
{
    public function delete(string $objectiveId): void
    {
        try {
            $eObjective = ObjectiveModel::query()->find($objectiveId);
            $eObjective->participants()->detach();
            $eObjective->softDelete();
        } catch (Throwable $e) {
            throw new ErrorOnSaveObjectiveException($e->getMessage());
        }
    }

    public function exists(string $objectiveId): bool
    {
        return ObjectiveModel::query()->where('id', $objectiveId)->exists();
    }

    /**
     * @throws Exception
     */
    public function ofId(?string $objectiveId): ?Objective
    {
        return ObjectiveModel::query()->find($objectiveId)?->toDomain();
    }

    /**
     * @throws ErrorOnSaveObjectiveException
     */
    public function save(ObjectiveSnapshot $objective): void
    {
        try {
            if ($objective->updatedAt) {
                $dbObjective = ObjectiveModel::query()->find($objective->id);
                $dbObjective->update($objective->toArray());
                $dbObjective->participants()->sync($objective->participantIds);

                return;
            }
            $dbObjective = ObjectiveModel::query()->create($objective->toArray());
            $dbObjective->participants()->attach($objective->participantIds);
        } catch (Throwable $t) {
            throw new ErrorOnSaveObjectiveException($t->getMessage());
        }
    }
}
