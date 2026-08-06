<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\GameController;

Route::post('/auth/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::post('/auth/register', [AuthController::class, 'register'])->middleware('throttle:10,1');

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/menu/game', [MenuController::class, 'createGame'])->middleware('throttle:60,1');
    Route::get('/menu/game', [MenuController::class, 'continueGame'])->middleware('throttle:60,1');
    Route::patch('/menu/name', [MenuController::class, 'renamePlayer'])->middleware('throttle:5,1');
    Route::delete('/menu/logout', [MenuController::class, 'exitMenu'])->middleware('throttle:60,1');
    Route::get('/menu/stats', [MenuController::class, 'showStats'])->middleware('throttle:60,1');
    Route::get('/menu/leaderboard/kolgold', [MenuController::class, 'showLeaderboardKolgold'])->middleware('throttle:60,1');
    Route::get('/menu/leaderboard/maxrooms', [MenuController::class, 'showLeaderboardMaxrooms'])->middleware('throttle:60,1');
    Route::get('/menu/leaderboard/kolrooms', [MenuController::class, 'showLeaderboardKolrooms'])->middleware('throttle:60,1');

    Route::post('/game/step', [GameController::class, 'openRoom'])->middleware('throttle:80,1');
});