<?php

namespace App\Core\Report\Infrastructure\Http\Controllers;

use App\Core\Report\Application\Query\All\GetAllReportsQueryHandler;
use App\Core\Report\Infrastructure\Factory\FilterReportCommandFactory;
use App\Core\Shared\Infrastructure\Http\Response\ApiErrorResponse;
use App\Core\Shared\Infrastructure\Http\Response\ApiSuccessResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Throwable;

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
    ): Responsable {
        try {

            $command = FilterReportCommandFactory::fromRequest($request);

            [$reports, $total] = $handler->handle($command);

            return new ApiSuccessResponse(
                data: [
                    'reports' => $reports,
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
