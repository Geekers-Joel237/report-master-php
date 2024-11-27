<?php

namespace App\Core\Objective\Infrastructure\Http\Controllers;

use App\Core\Objective\Application\Command\Save\SaveObjectiveHandler;
use App\Core\Objective\Infrastructure\Factories\SaveObjectiveCommandFactory;
use App\Core\Objective\Infrastructure\Http\Requests\SaveObjectiveRequest;
use Illuminate\Http\JsonResponse;

class SaveObjectiveAction
{
    public function __invoke(
        SaveObjectiveRequest $request,
        SaveObjectiveHandler $handler
    ): JsonResponse {
        $command = SaveObjectiveCommandFactory::fromRequest($request);
        $response = $handler->handle($command);

        return response()->json([
            'status' => true,
            'isSaved' => $response->isSaved,
            'reportId' => $response->objectiveId,
            'message' => $response->message,
        ]);
    }
}
