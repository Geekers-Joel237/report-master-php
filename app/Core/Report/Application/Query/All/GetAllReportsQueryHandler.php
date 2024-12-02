<?php

namespace App\Core\Report\Application\Query\All;

use App\Core\Report\Infrastructure\Models\Report;

class GetAllReportsQueryHandler
{
    public function handle(FilterReportCommand $command)
    {
        $query = Report::query()
            ->with(['owner', 'participants']);

        if (! empty($command->projectId)) {
            $query->where('project_id', $command->projectId);
        }

        if (! empty($command->userId)) {
            $query->where('owner_id', $command->userId);
        }

        if (! empty($command->year)) {
            $query->whereYear('created_at', $command->year);
        }

        if (! empty($command->startDate) && ! empty($command->endDate)) {
            $query->whereBetween('created_at', [$command->startDate, $command->endDate]);
        }

        if (! empty($command->participantId)) {
            $query->whereHas('participants', function ($q) use ($command) {
                $q->where('participant_id', $command->participantId);
            });
        }


        $reports = $query->paginate(10);


        $formattedReports = $reports->getCollection()->map(function ($report) {
            return [
                'report_id' => $report->id,
                'project_id' => $report->project_id,
                'project_name' => optional($report->project)->name ?? 'Unknown',
                'project_year' => optional($report->project)->created_at?->format('Y') ?? 'Unknown',
                'participants' => $report->participants->pluck('name')->toArray(), 
                'tasks' => $report->tasks,
            ];
        });


        return [
            'status' => true,
            'reports' => [
                'current_page' => $reports->currentPage(),
                'data' => $formattedReports,
                'total' => $reports->total(),
                'last_page' => $reports->lastPage(),
                'per_page' => $reports->perPage(),
            ],
        ];
    }

}
