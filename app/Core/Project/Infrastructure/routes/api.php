<?php

use App\Core\Project\Infrastructure\Http\Controllers\GetAllProjectsAction;
use App\Core\Project\Infrastructure\Http\Controllers\SaveProjectsAction;
use Illuminate\Support\Facades\Route;

Route::get('projects', GetAllProjectsAction::class);
Route::post('projects', SaveProjectsAction::class);
