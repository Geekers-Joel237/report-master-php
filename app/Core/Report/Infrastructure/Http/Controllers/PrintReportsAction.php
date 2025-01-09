<?php
    namespace App\Core\Report\Infrastructure\Http\Controllers;
    use App\Core\Report\Application\Query\All\GetAllReportsQueryHandler;
    use App\Core\Report\Infrastructure\Factory\FilterReportCommandFactory;
    use App\Core\Shared\Infrastructure\Http\Response\ApiErrorResponse;
    use App\Core\Shared\Infrastructure\Http\Response\ApiSuccessResponse;
    use Illuminate\Contracts\Support\Responsable;
    use Illuminate\Http\Request;
    use Illuminate\Routing\Controller;
    use Illuminate\Http\Response;
    use Dompdf\Dompdf;
    use Dompdf\Options;
    use Exception;


    class PrintReportsAction extends Controller
    {
        public function __invoke(Request $request, GetAllReportsQueryHandler $handler): Response
        {
            try {
                $command = FilterReportCommandFactory::fromRequest($request);

                [$reports, $total] = $handler->handle($command);

                if (empty($reports)) {
                    abort(404, 'Aucun rapport trouvé pour ces critères.');
                }

                $html = $this->generateHtmlForPdf($reports);

                $options = new Options();
                $options->set('defaultFont', 'Arial');
                $dompdf = new Dompdf($options);

                $dompdf->loadHtml($html);

                $dompdf->setPaper('A4', 'portrait');

                $dompdf->render();

                $output = $dompdf->output();

                return response($output, 200)
                    ->header('Content-Type', 'Report/pdf')
                    ->header('Content-Disposition', 'attachment; filename="filters_reports.pdf"');

            } catch (Exception $e) {

                abort(500, 'Une erreur est survenue lors de la génération du PDF.');

            }
        }

        private function generateHtmlForPdf(array $reports): string
        {
            $html = '<h1>Rapports Filtrés</h1>';
            $html .= '<table style="width:100%; border-collapse: collapse;">';
            $html .= '<thead><tr><th style="border: 1px solid black; padding: 8px;">ID</th><th style="border: 1px solid black; padding: 8px;">Titre</th><th style="border: 1px solid black; padding: 8px;">Date</th></tr></thead><tbody>';

            foreach ($reports as $report) {
                $html .= '<tr>';
                $html .= '<td style="border: 1px solid black; padding: 8px;">' . ($report->id ?? '') . '</td>'; 
                $html .= '<td style="border: 1px solid black; padding: 8px;">' . ($report->titre ?? '') . '</td>';
                $html .= '<td style="border: 1px solid black; padding: 8px;">' . ($report->date ? $report->date->format('Y-m-d') : '') . '</td>'; 
                $html .= '</tr>';
            }

            $html .= '</tbody></table>';

            return $html;
        }
    }
