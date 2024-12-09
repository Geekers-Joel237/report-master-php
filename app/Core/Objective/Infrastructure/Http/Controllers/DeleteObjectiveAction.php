<?php

namespace App\Core\Objective\Infrastructure\Http\Controllers;

use App\Core\Objective\Application\Command\Delete\DeleteObjectiveHandler;
use App\Core\Shared\Domain\Exceptions\ApiErrorException;
use App\Core\Shared\Infrastructure\Http\Response\ApiErrorResponse;
use App\Core\Shared\Infrastructure\Http\Response\ApiSuccessResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Throwable;

/**
 * @OA\Delete(
 *     path="/objectives/{objectiveId}",
 *     summary="Delete an objective",
 *     description="Delete a specific objective by ID",
 *     tags={"Objectives"},
 *
 *     @OA\Parameter(
 *         name="objectiveId",
 *         in="path",
 *         required=true,
 *         description="The ID of the objective to delete",
 *
 *         @OA\Schema(type="string")
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Objective deleted successfully",
 *
 *         @OA\JsonContent(
 *             type="object",
 *
 *             @OA\Property(property="status", type="boolean", description="Status of the operation"),
 *             @OA\Property(property="isDeleted", type="boolean", description="Whether the objective was deleted"),
 *             @OA\Property(property="message", type="string", description="Operation message")
 *         )
 *     )
 * )
 */
class DeleteObjectiveAction
{
    public function __invoke(
        DeleteObjectiveHandler $handler,
        Request $request
    ): Responsable {
        try {

            $response = $handler->handle($request->route('objectiveId'));

            return new ApiSuccessResponse(
                data: [
                    'isDeleted' => $response->isDeleted,
                    'message' => $response->message,
                ],
                code: 200
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
