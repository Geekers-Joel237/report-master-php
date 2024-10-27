<?php

namespace App\Core\Project\Infrastructure\Repositories;

use App\Core\Project\Domain\Entities\Project;
use App\Core\Project\Domain\Exceptions\ErrorOnSaveProjectException;
use App\Core\Project\Domain\Repositories\WriteProjectRepository;
use App\Core\Project\Domain\Snapshot\ProjectSnapshot;
use App\Core\Project\Infrastructure\Models\Project as ProjectModel;
use Exception;
use Throwable;

class EloquentWriteProjectRepository implements WriteProjectRepository
{
    public function ofId(string $projectId): ?Project
    {
        return ProjectModel::find($projectId)?->createFromModel();
    }

    public function ofName(string $value): ?Project
    {
        return ProjectModel::where(['name' => $value])->first()
            ?->createFromModel();

    }

    public function delete(string $existingProjectId): void
    {
        try {
            ProjectModel::findOrFail($existingProjectId)?->softDelete();
        } catch (Throwable|Exception $exception) {
            throw new ErrorOnSaveProjectException($exception->getMessage());
        }
    }

    public function exists(string $projectId): bool
    {
        return ProjectModel::where('id', $projectId)->exists();
    }

    /**
     * @throws ErrorOnSaveProjectException
     */
    public function save(ProjectSnapshot $project): void
    {
        try {
            ProjectModel::updateOrCreate(
                ['id' => $project->id],
                $project->toArray()
            );
        } catch (Throwable|Exception $exception) {
            throw new ErrorOnSaveProjectException($exception->getMessage());
        }
    }
}
