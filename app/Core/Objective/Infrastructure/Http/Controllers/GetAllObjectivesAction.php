<?php

namespace App\Core\Objective\Infrastructure\Http\Controllers;

use App\Core\Objective\Application\Query\All\GetAllObjectivesQueryHandler;
use App\Core\Objective\Infrastructure\Factories\FilterObjectivesCommandFactory;
use App\Core\Shared\Infrastructure\Http\Response\ApiErrorResponse;
use App\Core\Shared\Infrastructure\Http\Response\ApiSuccessResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Throwable;

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
    ): Responsable {
        try {
            $command = FilterObjectivesCommandFactory::fromRequest($request);

            [$objectives, $total] = $handler->handle($command);

            return new ApiSuccessResponse(
                data: [
                    'objectives' => $objectives,
                    'total' => $total,
                ],
            );

        } catch (Throwable $e) {
            return new ApiErrorResponse(
                message: $e->getMessage(),
                exception: $e,
            );
        }
    }
}
