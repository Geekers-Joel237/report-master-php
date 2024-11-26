<?php

namespace App\Core\Objective\Infrastructure\Http\Controllers;

use App\Core\Objective\Application\Query\All\GetAllObjectivesQueryHandler;
use App\Core\Objective\Infrastructure\Factories\FilterObjectivesCommandFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetAllObjectivesAction
{
    public function __invoke(
        Request $request,
        GetAllObjectivesQueryHandler $handler
    ): JsonResponse {
        $command = FilterObjectivesCommandFactory::fromRequest($request);

        return response()->json([
            'status' => true,
            'objectives' => $handler->handle($command),
        ]);
    }
}
