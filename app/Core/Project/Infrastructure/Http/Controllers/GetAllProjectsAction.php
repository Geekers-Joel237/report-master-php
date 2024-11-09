<?php

namespace App\Core\Project\Infrastructure\Http\Controllers;

use App\Core\Project\Application\Query\All\GetAllProjectsQueryHandler;
use App\Core\Project\Infrastructure\Factory\FilterProjectCommandFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetAllProjectsAction
{
    public function __invoke(
        Request $request,
        GetAllProjectsQueryHandler $queryHandler
    ): JsonResponse {
        $command = FilterProjectCommandFactory::fromRequest($request);
        $response = $queryHandler->handle($command);

        return response()->json([
            'status' => true,
            'projects' => $response,
        ]);
    }
}
