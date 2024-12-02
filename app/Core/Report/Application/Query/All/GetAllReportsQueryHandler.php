<?php

namespace App\Core\Report\Application\Query\All;

use App\Core\Report\Infrastructure\Models\Report;

class GetAllReportsQueryHandler
{
    public function handle(FilterReportCommand $command): array
    {
        $query = Report::query()
            ->with(['owner', 'participants', 'project']);

        if ($command->projectId) {
            $query->where('project_id', $command->projectId);
        }

        if ($command->ownerId) {
            $query->where('owner_id', $command->ownerId);
        }

        if ($command->year) {
            //TODO: query avec year
            $query->whereYear('created_at', $command->year);
        }

        if ($command->startDate && $command->endDate) {
            $query->whereBetween('created_at', [$command->startDate, $command->endDate]);
        }

        if (! empty($command->participantIds)) {
            //TODO: utiliser un whereIn ici, c'est un tableau
            $query->whereHas('participants', function ($q) use ($command) {
                $q->where('participant_id', $command->participantIds);
            });
        }

        //TODO: La pagination c'est avec limit et offset, Tu ne les utilises tout simplement pas
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
