<?php

use App\Core\Objective\Infrastructure\Http\Controllers\GetAllObjectivesAction;
use Illuminate\Support\Facades\Route;

Route::get('objectives', GetAllObjectivesAction::class);
