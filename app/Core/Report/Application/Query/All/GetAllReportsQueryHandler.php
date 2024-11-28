<?php

namespace App\Core\Report\Application\Query\All;

use App\Core\Report\Infrastructure\Models\Report;

class GetAllReportsQueryHandler
{
    
    public function handle(FilterReportCommand $command) {
        $query = Report::query()
            ->with(['owner', 'participants'])
            ->whereNull('deleted_at');


        if (!empty($command->projectId)) {
            $query->where('project_id', $command->projectId);
        }


        if (!empty($command->userId)) {
            $query->where('owner_id', $command->userId);
        }


        if (!empty($command->year)) {
            $query->whereYear('created_at', $command->year);
        }


        if (!empty($command->startDate) && !empty($command->endDate)) {
            $query->whereBetween('created_at', [$command->startDate, $command->endDate]);
        }


        if (!empty($command->participantId)) {
            $query->whereHas('participants', function ($q) use ($command) {
                $q->where('participant_id', $command->participantId);
            });
        }

        return $query->get();
    }
}
