<?php

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

Route::post('/sanctum/token', [\App\Http\Controllers\SanctumController::class, 'token'])
    ->name('sanctum:token');

Route::middleware('auth:sanctum')->post('/events', [\App\Http\Controllers\EventController::class, 'store'])
    ->name('events:store');

Route::middleware('auth:sanctum')->post('/sendBeacon', [\App\Http\Controllers\EventController::class, 'sendBeacon'])
    ->name('events:sendBeacon');
