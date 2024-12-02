<?php

namespace App\Core\Report\Infrastructure\Http\Controllers;

use App\Core\Report\Application\Command\Delete\DeleteReportHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Delete(
 *     path="/reports/{reportId}",
 *     summary="Delete a report",
 *     tags={"Reports"},
 *
 *     @OA\Parameter(
 *         name="reportId",
 *         in="path",
 *         description="ID of the report to delete",
 *         required=true,
 *
 *         @OA\Schema(type="string")
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Report deleted successfully",
 *
 *         @OA\JsonContent(
 *             type="object",
 *
 *             @OA\Property(property="status", type="boolean"),
 *             @OA\Property(property="isDeleted", type="boolean"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 */
class DeleteReportAction
{
    public function __invoke(
        DeleteReportHandler $handler,
        Request $request
    ): JsonResponse {
        $response = $handler->handle($request->route('reportId'));

        return response()->json([
            'status' => true,
            'isDeleted' => $response->isDeleted,
            'message' => $response->message,
        ]);

    }
}
