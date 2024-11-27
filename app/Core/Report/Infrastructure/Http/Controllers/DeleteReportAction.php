<?php

namespace App\Core\Report\Infrastructure\Http\Controllers;

use App\Core\Report\Application\Command\Delete\DeleteReportHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
