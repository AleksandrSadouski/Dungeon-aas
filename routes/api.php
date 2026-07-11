<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\GameController;

Route::post('/auth', [AuthController::class, 'identify']);
Route::post('/menu/{player}/game', [MenuController::class, 'createGame']);
Route::get('/menu/{player}/game', [MenuController::class, 'continueGame']);
Route::post('/game/{session}/step', [GameController::class, 'openRoom']);