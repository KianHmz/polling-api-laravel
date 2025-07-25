<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PollController;
use Illuminate\Support\Facades\Route;

Route::middleware('ensure.guest')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/user', [AuthController::class, 'user'])->name('user');

    Route::get('/polls', [PollController::class, 'index'])->name('index');
    Route::post('/polls/{pollId}/vote', [PollController::class, 'vote'])->name('vote');
    Route::get('/polls/{pollId}/results', [PollController::class, 'results']);
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('/polls', [PollController::class, 'store'])->name('store');
    Route::put('/polls/{pollId}', [PollController::class, 'update'])->name('update');
    Route::delete('/polls/{pollId}', [PollController::class, 'destroy'])->name('destroy');
});
