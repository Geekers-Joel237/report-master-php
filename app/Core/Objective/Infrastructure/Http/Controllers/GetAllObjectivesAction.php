<?php

namespace App\Core\Objective\Infrastructure\Http\Controllers;

use App\Core\Objective\Application\Query\All\GetAllObjectivesQueryHandler;
use App\Core\Objective\Infrastructure\Factories\FilterObjectivesCommandFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/objectives",
 *     summary="Get all objectives",
 *     description="Retrieve a list of all objectives based on filter criteria",
 *     tags={"Objectives"},
 *
 *     @OA\Parameter(
 *         name="filter",
 *         in="query",
 *         required=false,
 *         description="Filter to apply on objectives",
 *
 *         @OA\Schema(type="string")
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="List of objectives",
 *
 *         @OA\JsonContent(
 *             type="object",
 *
 *             @OA\Property(property="status", type="boolean", description="Status of the operation"),
 *             @OA\Property(property="objectives", type="array", description="List of objectives",
 *
 *                 @OA\Items(ref="#/components/schemas/Objective")
 *             )
 *         )
 *     )
 * )
 */
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
