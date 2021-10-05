<?php

use App\Http\Controllers\AnimalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('api')->group(function () {
    Route::post('set_field', [GameController::class, 'set_field']);
    Route::get('view_fields', [GameController::class, 'view_fields']);

    Route::prefix('game')->group(function () {
        Route::get('{id}/get_animals', [GameController::class, 'get_animals']);
        Route::get('{id}/next_move', [GameController::class, 'next_move']);

        Route::post('{id}/set_animal', [AnimalController::class, 'set_animal']);
        Route::post('{id}/set_random_animals', [AnimalController::class, 'set_random_animals']);
    });
});
