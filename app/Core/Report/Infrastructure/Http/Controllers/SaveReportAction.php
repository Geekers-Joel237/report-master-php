<?php

namespace App\Core\Report\Infrastructure\Http\Controllers;

use App\Core\Report\Application\Command\Save\SaveReportHandler;
use App\Core\Report\Infrastructure\Factory\SaveReportCommandFactory;
use App\Core\Report\Infrastructure\Http\Requests\SaveReportRequest;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Post(
 *     path="/reports",
 *     summary="Save a report",
 *     description="Creates a new report with tasks and participant IDs.",
 *     operationId="saveReport",
 *     tags={"Reports"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Report data to be saved",
 *         @OA\JsonContent(
 *             required={"tasks", "projectId"},
 *             @OA\Property(
 *                 property="tasks",
 *                 type="array",
 *                 description="List of tasks for the report",
 *                 @OA\Items(type="string", example="Task 1")
 *             ),
 *             @OA\Property(
 *                 property="participantIds",
 *                 type="array",
 *                 description="List of participant IDs for the report",
 *                 @OA\Items(type="string", example="12345")
 *             ),
 *             @OA\Property(
 *                 property="projectId",
 *                 type="string",
 *                 description="The ID of the project associated with the report",
 *                 example="project-id-123"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Report saved successfully.",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", description="Operation status", example=true),
 *             @OA\Property(property="isSaved", type="boolean", description="Indicates if the report was saved", example=true),
 *             @OA\Property(property="reportId", type="string", description="ID of the saved report", example="report-id-123"),
 *             @OA\Property(property="message", type="string", description="Confirmation message", example="Report saved successfully.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input data.",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", description="Operation status", example=false),
 *             @OA\Property(property="message", type="string", description="Error message", example="Validation error.")
 *         )
 *     )
 * )
 */
class SaveReportAction
{
    public function __invoke(
        SaveReportRequest $request,
        SaveReportHandler $handler
    ): JsonResponse {
        $command = SaveReportCommandFactory::fromRequest($request);
        $response = $handler->handle($command);

        return response()->json([
            'status' => true,
            'isSaved' => $response->isSaved,
            'reportId' => $response->reportId,
            'message' => $response->message,
        ]);
    }
}
