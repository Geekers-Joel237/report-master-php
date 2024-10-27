<?php

use App\Core\Project\Infrastructure\Http\Controllers\GetAllProjectsAction;
use Illuminate\Support\Facades\Route;

Route::get('projects', GetAllProjectsAction::class);
