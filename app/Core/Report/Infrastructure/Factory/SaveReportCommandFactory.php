<?php

namespace App\Core\Report\Infrastructure\Factory;

use App\Core\Report\Application\Command\Save\SaveReportCommand;
use App\Core\Report\Infrastructure\Http\Requests\SaveReportRequest;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class SaveReportCommandFactory
{
    public static function fromRequest(SaveReportRequest $request): SaveReportCommand
    {

        return new SaveReportCommand(
            tasks: $request->get('tasks'),
            participantIds: $request->get('participantIds'),
            projectId: $request->get('projectId'),
            ownerId: Auth::user()?->id ?? Uuid::uuid4()->toString(),
            reportId: $request->get('reportId')
        );
    }
}
