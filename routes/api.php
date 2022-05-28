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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', 'App\Http\Controllers\API\RegisterController@register');
Route::middleware('auth:sanctum')->group( function () {
    Route::resource('events', 'App\Http\Controllers\API\EventController');
    Route::resource('event-date', 'App\Http\Controllers\API\EventDateController');
});

Route::post('/login','App\Http\Controllers\LoginController@login')->middleware('cors');
