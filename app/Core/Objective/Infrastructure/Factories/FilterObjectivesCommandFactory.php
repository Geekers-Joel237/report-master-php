<?php

namespace App\Core\Objective\Infrastructure\Factories;

use App\Core\Objective\Application\Query\All\FilterObjectiveCommand;
use Illuminate\Http\Request;

class FilterObjectivesCommandFactory
{
    public static function fromRequest(Request $request): FilterObjectiveCommand
    {
        $command = new FilterObjectiveCommand;
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
