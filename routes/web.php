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

use App\Http\Controllers\UserController;
use App\User;

Route::get('/', function () {
    return view('welcome');
});


Route::get('login', 'UserController@login')->name('userlogin');
Route::post('userlogin', 'UserController@studentlogin')->name('userlogin');
Route::get('student', 'UserController@index')->name('user')->middleware(['auth:student']);
Route::get('logout', 'UserController@logout')->name('userlogout');

//  Route::get('/','UserController@index');

Route::get('/mark-all-read/{user}', function (User $user) {
    $user->unreadNotifications->markAsRead();
    return response(['message' => 'done', 'notifications' => $user->notifications]);
});

// Auth::routes();

// Route::get('/','UserController@index');
// Route::get('/logout','UserController@index');





Route::get('/admin/login', 'Auth\LoginController@showAdminLoginForm')->name('login');
Route::post('/admin/login', 'Auth\LoginController@adminLogin');
Route::post('/logout', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home');

Route::any('/admin/{any?}', 'AdminController@index')->where('any', '.*')->middleware(
    ['auth:admin', 'permission:ManageUser', 'role:Organization']
);
