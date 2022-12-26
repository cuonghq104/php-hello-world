<?php

use App\Http\Controllers\GameMatchController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PlayerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('team', [TeamController::class, 'index']);
// Route::post('team', [TeamController::class, 'store']);
// Route::get('team/{id}', [TeamController::class, 'show']);
// Route::delete('team/{id}', [TeamController::class, 'destroy']);
// Route::put('team/{id}', [TeamController::class, 'update']);

Route::apiResource('team', TeamController::class);
Route::apiResource('player', PlayerController::class);

Route::apiResource('game_match', GameMatchController::class);