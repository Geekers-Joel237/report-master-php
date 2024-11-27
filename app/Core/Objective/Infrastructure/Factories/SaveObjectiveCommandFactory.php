<?php

namespace App\Core\Objective\Infrastructure\Factories;

use App\Core\Objective\Application\Command\Save\SaveObjectiveCommand;
use App\Core\Objective\Infrastructure\Http\Requests\SaveObjectiveRequest;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class SaveObjectiveCommandFactory
{
    public static function fromRequest(SaveObjectiveRequest $request): SaveObjectiveCommand
    {

        return new SaveObjectiveCommand(
            tasks: $request->get('tasks'),
            participantIds: $request->get('participantIds'),
            projectId: $request->get('projectId'),
            ownerId: Auth::user()?->id ?? Uuid::uuid4()->toString(),
            objectiveId: $request->get('objectiveId'),
        );
    }
}
