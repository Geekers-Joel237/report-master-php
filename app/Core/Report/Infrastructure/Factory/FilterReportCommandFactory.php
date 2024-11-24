<?php

namespace App\Core\Report\Infrastructure\Factory;

use Illuminate\Http\Request;

class FilterReportCommandFactory
{
    public static function fromRequest(Request $request) {
        $command = new FilterReportCommand();
        $command->projectId = $request->query('projectId');
        $command->startDate = $request->query('startDate');
        $command->endDate = $request->query('endDate');
        return $command;
    }
}
