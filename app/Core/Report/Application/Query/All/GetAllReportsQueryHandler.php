<?php

namespace App\Core\Report\Application\Query\All;

use App\Core\Report\Infrastructure\Models\Report;

class GetAllReportsQueryHandler
{
    public function handle(FilterReportCommand $command): array
    {

        $query = Report::query()->with(['participants','owner','project']);


        if ($command->projectId) {
            $query->where('project_id', $command->projectId);
        }

        if ($command->ownerId) {
            $query->where('owner_id', $command->ownerId);
        }

        if ($command->year) {
            $query->whereHas('project', function ($q) use ($command){
                $q->where('years',$command->year);
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
            $query->whereHas('participants', function ($q) use ($command) {
                $q->whereIn('participant_id', $command->participantIds);
            });
        }

        $total = $query->get()->count();

        if ($command->limit && $command->offset) {
            $query->skip($command->offset)->take($command->limit);
        }


        $reports = $query->get()->map(function ($report) {
            return [
                'reportId' => $report->id,
                'projectId' => $report->project->id,
                'projectName' => $report->project->name,
                'year' => $report->project->years,
                'participants' => $report->participants->pluck('name')->toArray(),
                'tasks' => $report->tasks,
            ];
        });


        return [
            'status' => true,
            'reports' => [
                'data' => $reports,
                'total' => $total,
            ],
        ];
    }
}
