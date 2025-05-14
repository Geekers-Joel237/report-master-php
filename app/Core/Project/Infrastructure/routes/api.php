<?php

use App\Core\Project\Infrastructure\Http\Controllers\DeleteProjectAction;
use App\Core\Project\Infrastructure\Http\Controllers\GetAllProjectsAction;
use App\Core\Project\Infrastructure\Http\Controllers\SaveProjectAction;
use Illuminate\Support\Facades\Route;

Route::get('projects', GetAllProjectsAction::class);
Route::post('projects', SaveProjectAction::class);
Route::delete('projects/{projectId}', DeleteProjectAction::class);
