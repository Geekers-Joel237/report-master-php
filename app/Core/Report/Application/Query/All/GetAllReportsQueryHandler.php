<?php

namespace App\Core\Report\Application\Query\All;

use App\Core\Report\Infrastructure\Models\Report;

class GetAllReportsQueryHandler
{
    public function handle(FilterReportCommand $command): array
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

        if ($command->projectId) {
            $query->where('project_id', $command->projectId);
        }

        if ($command->ownerId) {
            $query->where('owner_id', $command->ownerId);
        }

        if ($command->year) {
            $query->whereHas('project.year', function ($q) use ($command) {
                $q->where('year', $command->year);
            });
        }

        if ($command->startDate && $command->endDate) {
            $query->whereBetween('created_at', [$command->startDate, $command->endDate]);
        } elseif ($command->startDate) {
            $query->where('created_at', '>=', $command->startDate);
        } elseif ($command->endDate) {
            $query->where('created_at', '<=', $command->endDate);
        }

        if ($command->participantIds) {
            $query->whereHas('participants', fn ($q) => $q->whereIn('participant_id', $command->participantIds));
        }

        $total = $query->count();

        if ($command->limit && $command->offset) {
            $query->skip($command->offset)->take($command->limit);
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
