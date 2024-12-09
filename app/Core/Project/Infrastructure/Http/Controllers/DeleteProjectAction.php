<?php

namespace App\Core\Project\Infrastructure\Http\Controllers;

use App\Core\Project\Application\Command\Delete\DeleteProjectHandler;
use App\Core\Shared\Domain\Exceptions\ApiErrorException;
use App\Core\Shared\Infrastructure\Http\Response\ApiErrorResponse;
use App\Core\Shared\Infrastructure\Http\Response\ApiSuccessResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Throwable;

/**
 * @OA\Delete(
 *     path="/projects/{projectId}",
 *     summary="Delete a project",
 *     description="Deletes a project by its ID.",
 *     operationId="deleteProject",
 *     tags={"Projects"},
 *
 *     @OA\Parameter(
 *         name="projectId",
 *         in="path",
 *         required=true,
 *         description="ID of the project to delete",
 *
 *         @OA\Schema(type="string", example=1)
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Project deleted successfully.",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="status", type="boolean", description="Operation status", example=true),
 *             @OA\Property(property="isDeleted", type="boolean", description="Indicates if the project was deleted", example=true),
 *             @OA\Property(property="message", type="string", description="Confirmation message", example="Project successfully deleted.")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=404,
 *         description="Project not found.",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="status", type="boolean", description="Operation status", example=false),
 *             @OA\Property(property="message", type="string", description="Error message", example="Project not found.")
 *         )
 *     )
 * )
 */
class DeleteProjectAction
{
    public function __invoke(
        DeleteProjectHandler $handler,
        Request $request
    ): Responsable {
        try {

            $response = $handler->handle($request->route('projectId'));

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
