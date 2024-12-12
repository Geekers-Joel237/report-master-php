<?php

namespace App\Core\Project\Infrastructure\Http\Controllers;

use App\Core\Project\Application\Command\Save\SaveProjectCommand;
use App\Core\Project\Application\Command\Save\SaveProjectHandler;
use App\Core\Project\Infrastructure\Http\Requests\SaveProjectRequest;
use App\Core\Shared\Domain\Exceptions\ApiErrorException;
use App\Core\Shared\Infrastructure\Http\Response\ApiErrorResponse;
use App\Core\Shared\Infrastructure\Http\Response\ApiSuccessResponse;
use Illuminate\Contracts\Support\Responsable;
use Throwable;

/**
 * @OA\Info(title="Report-Master", version="0.1")
 *
 * @OA\Server(url ="https://report-master.com/v1",description="An Application to manage differents reports")
 *
 * @OA\Post(
 *     path="/projects/save",
 *     summary="Save a project",
 *     description="Creates or updates a project with the provided data.",
 *     operationId="saveProject",
 *     tags={"Projects"},
 *
 *     @OA\RequestBody(
 *         required=true,
 *
 *         @OA\JsonContent(
 *             required={"name"},
 *
 *             @OA\Property(property="name", type="string", description="The name of the project", example="My Project"),
 *             @OA\Property(property="description", type="string", description="The project description", example="This is an awesome project."),
 *             @OA\Property(property="projectId", type="integer", description="ID of the existing project (for updates)", example=123)
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=201,
 *         description="Project successfully saved.",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="status", type="boolean", description="The status of the save operation", example=true),
 *             @OA\Property(property="isSaved", type="boolean", description="Indicates if the project was saved", example=true),
 *             @OA\Property(property="projectId", type="integer", description="ID of the saved project", example=123),
 *             @OA\Property(property="message", type="string", description="Success or error message", example="Project saved successfully.")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=400,
 *         description="Validation error.",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="status", type="boolean", description="Error status", example=false),
 *             @OA\Property(property="message", type="string", description="Error message", example="Required fields are missing.")
 *         )
 *     )
 * )
 */
class SaveProjectAction
{
    public function __invoke(
        SaveProjectHandler $handler,
        SaveProjectRequest $request
    ): Responsable {
        try {

            $command = new SaveProjectCommand(
                name: $request->get('name'),
                description: $request->get('description'),
                projectId: $request->get('projectId')
            );
            $response = $handler->handle($command);

            return new ApiSuccessResponse(
                data: [
                    'isSaved' => $response->isSaved,
                    'projectId' => $response->projectId,
                    'message' => $response->message,
                ],
                code: $response->code
            );

        } catch (ApiErrorException|Throwable $e) {
            if ($e instanceof ApiErrorException) {
                return new ApiErrorResponse(
                    message: $e->getMessage(),
                    exception: $e,
                    code: $e->getCode()
                );
            }

            return new ApiErrorResponse(
                message: $e->getMessage(),
                exception: $e
            );
        }
    }
}
