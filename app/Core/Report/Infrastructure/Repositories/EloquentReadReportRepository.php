<?php

namespace App\Core\Report\Infrastructure\Repositories;

use App\Core\Report\Domain\Dto\FilterReportParams;
use App\Core\Report\Domain\Repositories\ReadReportRepository;
use App\Core\Report\Infrastructure\Models\Report;

class EloquentReadReportRepository implements ReadReportRepository
{
    public function filter(FilterReportParams $params): array
    {

        $query = Report::query()->with([
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

        $reports = $query->get()->map(function ($report) {
            return [
                'reportId' => $report->id,
                'projectId' => $report->project->id,
                'projectName' => $report->project->name,
                'year' => $report->project->year->year,
                'participants' => $report->participants->pluck('name')->toArray(),
                'tasks' => $report->tasks,
            ];
        });

        return [
            $reports,
            $total,
        ];
    }
}
