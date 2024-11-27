<?php

namespace App\Core\Project\Infrastructure\Repositories;

use App\Core\Project\Domain\Entities\Project;
use App\Core\Project\Domain\Exceptions\ErrorOnSaveProjectException;
use App\Core\Project\Domain\Repositories\WriteProjectRepository;
use App\Core\Project\Domain\Snapshot\ProjectSnapshot;
use App\Core\Project\Infrastructure\Models\Project as ProjectModel;
use App\Core\Shared\Infrastructure\Models\Years;
use Exception;
use Illuminate\Support\Str;
use Throwable;

class EloquentWriteProjectRepository implements WriteProjectRepository
{
    /**
     * @throws Exception
     */
    public function ofId(string $projectId): ?Project
    {
        return ProjectModel::query()->find($projectId)?->createFromModel();
    }

    /**
     * @throws Exception
     */
    public function ofSlug(string $value): ?Project
    {
        return ProjectModel::query()->where(['slug' => Str::slug($value)])->first()
            ?->createFromModel();

    }

    public function delete(string $existingProjectId): void
    {
        try {
            ProjectModel::query()->find($existingProjectId)->softDelete();
        } catch (Throwable|Exception $exception) {
            throw new ErrorOnSaveProjectException($exception->getMessage());
        }
    }

    public function exists(string $projectId): bool
    {
        return ProjectModel::query()->where('id', $projectId)->exists();
    }

    /**
     * @throws ErrorOnSaveProjectException
     */
    public function save(ProjectSnapshot $project): void
    {
        try {
            ProjectModel::query()->updateOrCreate(
                ['id' => $project->id],
                array_merge($project->toArray(), ['year_id' => $this->getActiveYearsIdentifier()])
            );
        } catch (Throwable|Exception $exception) {
            throw new ErrorOnSaveProjectException($exception->getMessage());
        }
    }

    private function getActiveYearsIdentifier(): string
    {
        return Years::query()->select(['id'])->where(['is_active' => true])->first()->id;
    }
}
