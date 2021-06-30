<?php

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

use App\User;

//Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mark-all-read/{user}', function (User $user) { 
    $user->unreadNotifications->markAsRead();
    return response(['message'=>'done', 'notifications'=>$user->notifications]);
});

/**
 * Student Routes
 */
Route::group(['prefix'=>'/student','middleware'=>'student'],function(){
    Route::get('/login', 'Student\StudentLoginController@login');
    Route::post('/student/login', 'Student\StudentLoginController@studentlogin')->name('student.login');
});
Route::group(['prefix'=>'/student','middleware'=>'auth:student'],function(){
    Route::get('/', 'Student\StudentController@index');
    Route::post('/logout', 'Student\StudentLoginController@logout')->name('student.logout');
});
//Route::any('/student/{any?}', 'Student\StudentController@index')->where('any','.*')->middleware('auth:admin');

/**
 * Admin Routes
 */
Route::get('/admin/login', 'Auth\LoginController@showAdminLoginForm')->name('login');
Route::post('/admin/login', 'Auth\LoginController@adminLogin');
Route::post('/logout', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home');

Route::any('/admin/{any?}', 'AdminController@index')->where('any','.*')->middleware(
    ['auth:admin','permission:ManageUser','role:Organization']);