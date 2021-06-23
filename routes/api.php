<?php

<<<<<<< Updated upstream

=======
use App\Http\Controllers\StudentController;
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream


Route::get('/apiResource', 'QuizeController@index');
Route::post('/apiResource', 'QuizeController@store');
Route::get('/apiResource/{id}', 'QuizeController@show');
Route::put('/apiResource/{id}', 'QuizeController@update');
Route::delete('/apiResource/{id}', 'QuizeController@destroy');



Route::get('question','QuestionController@index');
Route::post('question','QuestionController@store');
Route::get('question/{id}','QuestionController@show');
Route::put('question/{id}','QuestionController@update');
Route::delete('question/{id}','QuestionController@destroy');

Route::get('option','OptionController@index');
Route::post('option','OptionController@store');
Route::get('option/{id}','OptionController@show');
Route::put('option/{id}','OptionController@update');
Route::delete('option/{id}','OptionController@destroy');


Route::get('join','JoinTableController@index');
=======
>>>>>>> Stashed changes
