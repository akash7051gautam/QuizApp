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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/apiResource', 'QuizController@index');
Route::post('/apiResource', 'QuizController@store');
Route::get('/apiResource/{id}', 'QuizController@show');
Route::put('/apiResource/{id}', 'QuizController@update');
Route::delete('/apiResource/{id}', 'QuizController@destroy');
