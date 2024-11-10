<?php

namespace App\Core\Project\Infrastructure\Http\Controllers;

use App\Core\Project\Application\Command\Delete\DeleteProjectHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeleteProjectAction
{
    public function __invoke(
        DeleteProjectHandler $handler,
        Request $request
    ): JsonResponse {
        $response = $handler->handle($request->route('projectId'));

        return response()->json([
            'status' => true,
            'isDeleted' => $response->isDeleted,
            'message' => $response->message,
        ]);

    }
}
