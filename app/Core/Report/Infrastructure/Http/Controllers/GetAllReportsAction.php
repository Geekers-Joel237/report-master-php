<?php

namespace App\Core\Report\Infrastructure\Http\Controllers;

use App\Core\Report\Application\Query\All\GetAllReportsQueryHandler;
use App\Core\Report\Infrastructure\Factory\FilterReportCommandFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/reports",
 *     summary="Retrieve all reports",
 *     tags={"Reports"},
 *
 *     @OA\Parameter(
 *         name="filters",
 *         in="query",
 *         description="Optional filters to apply",
 *         required=false,
 *
 *         @OA\Schema(type="string")
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="List of all reports",
 *
 *         @OA\JsonContent(
 *             type="object",
 *
 *             @OA\Property(property="status", type="boolean"),
 *             @OA\Property(
 *                 property="reports",
 *                 type="array",
 *
 *                 @OA\Items(ref="#/components/schemas/Report")
 *             )
 *         )
 *     )
 * )
 */
class GetAllReportsAction
{
    public function __invoke(
        Request $request,
        GetAllReportsQueryHandler $handler
    ): JsonResponse {
        $command = FilterReportCommandFactory::fromRequest($request);

        return response()->json([
            'status' => true,
            'reports' => $handler->handle($command),
        ]);
    }
}
