<?php

namespace App\Core\Project\Infrastructure\Http\Controllers;

use App\Core\Project\Application\Command\Save\SaveProjectCommand;
use App\Core\Project\Application\Command\Save\SaveProjectHandler;
use App\Core\Project\Infrastructure\Http\Requests\SaveProjectRequest;
use Illuminate\Http\JsonResponse;

class SaveProjectsAction
{
    public function __invoke(
        SaveProjectHandler $handler,
        SaveProjectRequest $request
    ): JsonResponse {
        $command = new SaveProjectCommand(
            name: $request->get('name'),
            description: $request->get('description'),
            projectId: $request->get('projectId')
        );
        $response = $handler->handle($command);

        return response()->json([
            'status' => true,
            'isSaved' => $response->isSaved,
            'projectId' => $response->projectId,
        ]);
    }
}
