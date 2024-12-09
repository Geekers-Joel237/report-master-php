<?php

namespace App\Core\Objective\Infrastructure\Http\Controllers;

use App\Core\Objective\Application\Command\Save\SaveObjectiveHandler;
use App\Core\Objective\Infrastructure\Factories\SaveObjectiveCommandFactory;
use App\Core\Objective\Infrastructure\Http\Requests\SaveObjectiveRequest;
use App\Core\Shared\Domain\Exceptions\ApiErrorException;
use App\Core\Shared\Infrastructure\Http\Response\ApiErrorResponse;
use App\Core\Shared\Infrastructure\Http\Response\ApiSuccessResponse;
use Illuminate\Contracts\Support\Responsable;
use Throwable;

/**
 * @OA\Post(
 *     path="/objectives",
 *     summary="Create or save an objective",
 *     description="Save a new objective or update an existing one",
 *     tags={"Objectives"},
 *
 *     @OA\RequestBody(
 *         required=true,
 *
 *         @OA\JsonContent(ref="#/components/schemas/SaveObjectiveRequest")
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Objective saved successfully",
 *
 *         @OA\JsonContent(
 *             type="object",
 *
 *             @OA\Property(property="status", type="boolean", description="Status of the operation"),
 *             @OA\Property(property="isSaved", type="boolean", description="Whether the objective was saved"),
 *             @OA\Property(property="objectiveId", type="string", description="The ID of the saved objective"),
 *             @OA\Property(property="message", type="string", description="Operation message")
 *         )
 *     )
 * )
 */
class SaveObjectiveAction
{
    public function __invoke(
        SaveObjectiveRequest $request,
        SaveObjectiveHandler $handler
    ): Responsable {
        try {

            $command = SaveObjectiveCommandFactory::fromRequest($request);
            $response = $handler->handle($command);

            return new ApiSuccessResponse(
                data: [
                    'isSaved' => $response->isSaved,
                    'reportId' => $response->objectiveId,
                    'message' => $response->message,
                ],
                code: 201
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
