<?php

use App\Core\Report\Infrastructure\Http\Controllers\DeleteReportAction;
use App\Core\Report\Infrastructure\Http\Controllers\ExportReportsToPdfAction;
use App\Core\Report\Infrastructure\Http\Controllers\GetAllReportsAction;
use App\Core\Report\Infrastructure\Http\Controllers\SaveReportAction;
use Illuminate\Support\Facades\Route;

Route::post('reports', SaveReportAction::class);
Route::delete('reports/{reportId}', DeleteReportAction::class);
Route::get('reports', GetAllReportsAction::class);
Route::get('reports/export/pdf', ExportReportsToPdfAction::class);

