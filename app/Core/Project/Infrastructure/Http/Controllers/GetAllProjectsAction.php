<?php

namespace App\Core\Project\Infrastructure\Http\Controllers;

use App\Core\Project\Application\Query\All\GetAllProjectsQueryHandler;
use Illuminate\Http\JsonResponse;

class GetAllProjectsAction
{
    public function __invoke(
        GetAllProjectsQueryHandler $queryHandler
    ): JsonResponse {
        $response = $queryHandler->handle();

        return response()->json([
            'status' => true,
            'projects' => $response,
        ]);
    }
}
