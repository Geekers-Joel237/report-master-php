<?php

use App\Core\Report\Application\Query\All\GetAllReportsQueryHandler;
use App\Core\Report\Infrastructure\Http\Controllers\DeleteReportAction;
use App\Core\Report\Infrastructure\Http\Controllers\GetAllReportsAction;
use App\Core\Report\Infrastructure\Http\Controllers\SaveReportAction;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('reports', SaveReportAction::class);
    Route::delete('reports/{reportId}', DeleteReportAction::class);
    Route::get('reports', GetAllReportsAction::class);
    Route::post('weekly-reports', PrintReportsAction::class);
});
