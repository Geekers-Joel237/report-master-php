<?php

namespace App\Core\Objective\Infrastructure\Repository;

use App\Core\Objective\Domain\Dto\FilterObjectiveParams;
use App\Core\Objective\Domain\Repository\ReadObjectiveRepository;
use App\Core\Objective\Infrastructure\Model\Objective;

class EloquentReadObjectiveRepository implements ReadObjectiveRepository
{
    public function filter(FilterObjectiveParams $params): array
    {
        $query = Objective::query()->with([
            'participants' => function ($q) {
                $q->select('id', 'report_id', 'name');
            },
            'owner' => function ($q) {
                $q->select('id', 'name');
            },
            'project' => function ($q) {
                $q->select('id', 'name', 'year_id');
            },
            'project.year' => function ($q) {
                $q->select('id', 'year');
            },
        ]);

        if ($params->projectId) {
            $query->where('project_id', $params->projectId);
        }

        if ($params->ownerId) {
            $query->where('owner_id', $params->ownerId);
        }

        if ($params->year) {
            $query->whereHas('project.year', function ($q) use ($params) {
                $q->where('year', $params->year);
            });
        }

        if ($params->startDate && $params->endDate) {
            $query->whereBetween('created_at', [$params->startDate, $params->endDate]);
        } elseif ($params->startDate) {
            $query->where('created_at', '>=', $params->startDate);
        } elseif ($params->endDate) {
            $query->where('created_at', '<=', $params->endDate);
        }

        if ($params->participantIds) {
            $query->whereHas('participants', fn ($q) => $q->whereIn('participant_id', $params->participantIds));
        }

        $total = $query->count();

        if ($params->limit && $params->offset) {
            $query->skip($params->offset)->take($params->limit);
        }

        $objectives = $query->get()->map(function ($objective) {
            return [
                'objectiveId' => $objective->id,
                'projectId' => $objective->project->id,
                'projectName' => $objective->project->name,
                'year' => $objective->project->year->year,
                'participants' => $objective->participants->pluck('name')->toArray(),
                'tasks' => $objective->tasks,
                'owner' => $objective->owner?->name,
            ];
        });

        return [
            $objectives,
            $total,
        ];
    }
}
