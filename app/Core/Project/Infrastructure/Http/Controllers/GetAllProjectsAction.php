<?php

namespace App\Core\Project\Infrastructure\Http\Controllers;

use App\Core\Project\Application\Query\All\GetAllProjectsQueryHandler;
use App\Core\Project\Infrastructure\Factory\FilterProjectCommandFactory;
use App\Core\Shared\Infrastructure\Http\Response\ApiErrorResponse;
use App\Core\Shared\Infrastructure\Http\Response\ApiSuccessResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

/**
 * @OA\Get(
 *     path="/projects",
 *     summary="Retrieve all projects",
 *     description="Fetches a list of all projects with optional filters.",
 *     operationId="getAllProjects",
 *     tags={"Projects"},
 *
 *     @OA\Parameter(
 *         name="name",
 *         in="query",
 *         description="Filter projects by name",
 *         required=false,
 *
 *         @OA\Schema(type="string", example="Project Alpha")
 *     ),
 *
 *     @OA\Parameter(
 *         name="status",
 *         in="query",
 *         description="Filter projects by status",
 *         required=false,
 *
 *         @OA\Schema(type="string", example="active")
 *     ),
 *
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="The page number for pagination",
 *         required=false,
 *
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *
 *     @OA\Parameter(
 *         name="per_page",
 *         in="query",
 *         description="The number of items per page",
 *         required=false,
 *
 *         @OA\Schema(type="integer", example=10)
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="List of projects retrieved successfully.",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="status", type="boolean", description="Operation status", example=true),
 *             @OA\Property(
 *                 property="projects",
 *                 type="array",
 *                 description="List of projects",
 *
 *                 @OA\Items(
 *                     type="object",
 *
 *                     @OA\Property(property="id", type="string", description="Project ID", example=1),
 *                     @OA\Property(property="name", type="string", description="Project name", example="Project Alpha"),
 *                     @OA\Property(property="status", type="string", description="Project status", example="active"),
 *                     @OA\Property(property="created_at", type="string", format="date-time", description="Creation date", example="2023-01-01T12:00:00Z")
 *                 )
 *             )
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input or filter parameters.",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="status", type="boolean", description="Operation status", example=false),
 *             @OA\Property(property="message", type="string", description="Error message", example="Invalid filter parameters.")
 *         )
 *     )
 * )
 */
class GetAllProjectsAction
{
    public function __invoke(
        Request $request,
        GetAllProjectsQueryHandler $queryHandler
    ): Responsable {

        try {
            $command = FilterProjectCommandFactory::fromRequest($request);
            $response = $queryHandler->handle($command);

            return new ApiSuccessResponse(
                data: [
                    'projects' => $response,
                ],
                code: ResponseAlias::HTTP_OK
            );

        } catch (Throwable $e) {
            return new ApiErrorResponse(
                message: $e->getMessage(),
                exception: $e
            );
        }
    }
}
