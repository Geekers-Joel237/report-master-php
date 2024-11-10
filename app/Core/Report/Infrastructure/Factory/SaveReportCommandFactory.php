<?php

namespace App\Core\Report\Infrastructure\Factory;

use App\Core\Report\Application\Command\Save\SaveReportCommand;
use App\Core\Report\Infrastructure\Http\Requests\SaveReportRequest;
use App\Core\Shared\Domain\Exceptions\InvalidCommandException;

class SaveReportCommandFactory
{
    /**
     * @throws InvalidCommandException
     */
    public static function fromRequest(SaveReportRequest $request): SaveReportCommand
    {
        self::validate($request);

        return new SaveReportCommand(
            tasks: $request->get('tasks'),
            participantIds: $request->get('participantIds'),
            projectId: $request->get('projectId'),
            reportId: $request->get('reportId')
        );
    }

    /**
     * @throws InvalidCommandException
     */
    private static function validate(SaveReportRequest $request): void
    {
        if (empty($request->get('tasks'))) {
            throw new InvalidCommandException('Tasks is required');
        }
    }
}
