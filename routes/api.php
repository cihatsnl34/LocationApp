<?php

use App\Http\Controllers\LocationController;
use App\Http\Controllers\RouteController;
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

Route::prefix('location')->group(function () {
    Route::middleware('throttle:60,1')->group(function () {
        Route::post('/create', [LocationController::class, 'store']);
        Route::post('/update/{id}', [LocationController::class, 'update']);
        Route::get('/list', [LocationController::class, 'list']);
        Route::get('/select/{id}', [LocationController::class, 'select']);
    });
});

Route::middleware('throttle:60,1')->group(function () {
    Route::post('/route', [RouteController::class, 'route']);
});
