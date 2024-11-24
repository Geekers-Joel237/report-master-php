<?php

namespace App\Core\Report\Infrastructure\Http\Controllers;

use App\Core\Report\Infrastructure\Factory\FilterReportCommandFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetAllReportsAction
{
    public function __invoke(
        Request $request,
        GetAllReportsQueryHandler $handler
    ): JsonResponse {
        $command = FilterReportCommandFactory::fromRequest($request);

        return response()->json([
            'status' => true,
            'reports' => $handler->handle($command),
        ]);
    }
}
