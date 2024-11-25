<?php

namespace App\Core\Report\Infrastructure\Factory;

use App\Core\Report\Application\Query\All\FilterReportCommand;
use Illuminate\Http\Request;

class FilterReportCommandFactory
{
    public static function fromRequest(Request $request): FilterReportCommand
    {
        $command = new FilterReportCommand;
        $command->projectId = $request->query('projectId');
        $command->startDate = $request->query('startDate');
        $command->endDate = $request->query('endDate');
        $command->year = $request->query('year');
        $command->ownerId = $request->query('ownerId');
        $command->participantIds = $request->query('participantIds');
        $command->limit = $request->query('limit');
        $command->offset = $request->query('offset');

        return $command;
    }
}
