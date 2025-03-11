<?php

use App\Core\Auth\Infrastructure\Http\Controllers\AuthUserAction;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->post('/login', [AuthUserAction::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->post('/logout', [AuthUserAction::class, 'logout'])->name('logout');
