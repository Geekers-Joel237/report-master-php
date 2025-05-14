<?php

namespace App\Core\Report\Infrastructure\Http\Controllers;

use App\Core\Report\Application\Query\All\GetAllReportsQueryHandler;
use App\Core\Report\Infrastructure\Factory\FilterReportCommandFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

readonly class ExportReportsToPdfAction
{
    public function __construct(private GetAllReportsQueryHandler $handler) {}

    public function __invoke(Request $request): Response|JsonResponse
    {
        try {

            $command = FilterReportCommandFactory::fromRequest($request);

            [$reports, $total] = $this->handler->handle($command);

            if ($total === 0) {
                return response()->json(['message' => 'Aucun rapport trouvé pour les dates spécifiées.'], 404);
            }

            $html = view('Reports::pdf', compact('reports'))->render();

            $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape');

            return $pdf->download('reports_'.date('Y-m-d').'.pdf');
        } catch (Throwable $e) {

            Log::error('Erreur lors de l\'exportation des rapports en PDF : ', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'message' => 'Une erreur s\'est produite lors de la génération du fichier PDF.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
