<?php

namespace App\Core\Project\Infrastructure\Factory;

use App\Core\Project\Application\Query\All\FilterProjectCommand;
use Illuminate\Http\Request;

class FilterProjectCommandFactory
{
    public static function fromRequest(Request $request): FilterProjectCommand
    {
        $command = new FilterProjectCommand;
        $command->year = $request->query('year');
        $command->status = $request->query('status');

        return $command;
    }
}
