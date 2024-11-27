<?php

namespace App\Core\Objective\Infrastructure\Http\Controllers;

use App\Core\Objective\Application\Command\Delete\DeleteObjectiveHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeleteObjectiveAction
{
    public function __invoke(
        DeleteObjectiveHandler $handler,
        Request $request
    ): JsonResponse {
        $response = $handler->handle($request->route('objectiveId'));

        return response()->json([
            'status' => true,
            'isDeleted' => $response->isDeleted,
            'message' => $response->message,
        ]);

    }
}
