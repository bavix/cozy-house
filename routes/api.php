<?php

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

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'app_name' => 'required',
    ]);

    $user = \App\Models\User::where('email', $request->email)->first();

    if (!$user || !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    $token = $user->createToken($request->app_name)->plainTextToken;

    return compact('token');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/dictionaries', 'DictionaryController@index')
    ->name('dictionaries:index');

Route::middleware('auth:sanctum')->post('/events', 'EventController@store')
    ->name('events:store');

Route::middleware('auth:sanctum')->post('/sendBeacon', 'EventController@sendBeacon')
    ->name('events:sendBeacon');

//Route::post('/hello', function (Request $request) {
//    return [
//        'language' => $request->getPreferredLanguage(),
//        'referer' => $request->header('referer'),
//        'uri' => $request->input('uri'),
//    ];
//});
//
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
