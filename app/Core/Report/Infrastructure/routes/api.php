<?php

use App\Core\Report\Infrastructure\Http\Controllers\SaveReportAction;
use Illuminate\Support\Facades\Route;

Route::post('reports', SaveReportAction::class);