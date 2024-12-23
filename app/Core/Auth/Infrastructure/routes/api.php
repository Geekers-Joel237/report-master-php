<?php

use App\Core\Auth\Infrastructure\Http\Controllers\AuthUserAction;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthUserAction::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->post('/logout', [AuthUserAction::class, 'logout']);
