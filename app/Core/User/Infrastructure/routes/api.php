<?php

use App\Core\User\Infrastructure\Http\Controllers\CreateUserAction;
use App\Core\User\Infrastructure\Http\Controllers\DeleteUserAction;
use App\Core\User\Infrastructure\Http\Controllers\GetUserProfileAction;
use App\Core\User\Infrastructure\Http\Controllers\UpdateUserAction;
use Illuminate\Support\Facades\Route;

Route::post('/users', CreateUserAction::class);
Route::middleware('auth:sanctum')->group(function () {
    Route::put('/users/{userId}', UpdateUserAction::class);
    Route::get('/users/{userId}', GetUserProfileAction::class);
    Route::delete('/user/{userId}', DeleteUserAction::class);

});
