<?php

use App\Core\Objective\Infrastructure\Http\Controllers\DeleteObjectiveAction;
use App\Core\Objective\Infrastructure\Http\Controllers\GetAllObjectivesAction;
use App\Core\Objective\Infrastructure\Http\Controllers\SaveObjectiveAction;
use Illuminate\Support\Facades\Route;

Route::post('objectives', SaveObjectiveAction::class);
Route::delete('objectives/{objectiveId}', DeleteObjectiveAction::class);
Route::get('objectives', GetAllObjectivesAction::class);
