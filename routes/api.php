<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\GameController;

Route::post('/auth', [AuthController::class, 'identify'])->middleware('throttle:10,1');
Route::post('/menu/{player}/game', [MenuController::class, 'createGame'])->middleware('throttle:60,1');
Route::get('/menu/{player}/game', [MenuController::class, 'continueGame'])->middleware('throttle:60,1');
Route::post('/game/{session}/step', [GameController::class, 'openRoom'])->middleware('throttle:80,1');