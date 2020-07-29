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

Route::post('/sanctum/token', 'SanctumController@token')
    ->name('sanctum:token');

Route::middleware('auth:sanctum')->post('/events', 'EventController@store')
    ->name('events:store');

Route::middleware('auth:sanctum')->post('/sendBeacon', 'EventController@sendBeacon')
    ->name('events:sendBeacon');
