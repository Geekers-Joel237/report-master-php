<?php

namespace App\Core\Report\Infrastructure\Http\Controllers;

use App\Core\Report\Application\Command\Delete\DeleteReportHandler;
use App\Core\Shared\Domain\Exceptions\ApiErrorException;
use App\Core\Shared\Infrastructure\Http\Response\ApiErrorResponse;
use App\Core\Shared\Infrastructure\Http\Response\ApiSuccessResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Throwable;

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
    ): Responsable {

        try {
            $response = $handler->handle($request->route('reportId'));

            return new ApiSuccessResponse(
                data: [
                    'isDeleted' => $response->isDeleted,
                    'message' => $response->message,
                ],
                code: $response->code
            );

        } catch (ApiErrorException|Throwable $e) {
            return new ApiErrorResponse(
                message: $e->getMessage(),
                exception: $e,
                code: $e->getCode()
            );
        }

    }
}
