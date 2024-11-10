<?php

namespace App\Core\Report\Infrastructure\Http\Controllers;

use App\Core\Report\Application\Command\Save\SaveReportHandler;
use App\Core\Report\Infrastructure\Factory\SaveReportCommandFactory;
use App\Core\Report\Infrastructure\Http\Requests\SaveReportRequest;
use Illuminate\Http\JsonResponse;

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
