<?php

use App\Core\User\Infrastructure\Http\Controllers\CreateUserAction;
use App\Core\User\Infrastructure\Http\Controllers\GetUserProfileAction;
use App\Core\User\Infrastructure\Http\Controllers\UpdateUserAction;
use Illuminate\Support\Facades\Route;

Route::post('/users', CreateUserAction::class);
Route::put('/users/{userId}', UpdateUserAction::class);
Route::get('/users/{userId}', GetUserProfileAction::class);
