<?php


use Illuminate\Http\Request;

Route::apiResource('users', 'AdminApi\UserController');
Route::apiResource('roles', 'AdminApi\RoleController');
Route::apiResource('permissions', 'AdminApi\PermissionController');
Route::apiResource('blogs', 'BlogController')->middleware('auth');

Route::post('blogs/{blog}/update-image', 'BlogController@updateFeaturedImage')->middleware('auth');

<<<<<<< Updated upstream
Route::apiResource('categories', 'CategoryController')->middleware('auth');
Route::get('activities/{userId?}', 'AdminApi\ActivityController@index');
=======
// Route::post('blogs/{blog}/update-image', 'BlogController@updateFeaturedImage')->middleware('auth');

// Route::apiResource('categories', 'CategoryController')->middleware('auth');
Route::get('activities/{userId?}', 'AdminApi\ActivityController@index'); 

Route::apiResource('questions', 'AdminApi\QuestionController')->middleware(['auth:admin','permission:ManageUser','role:Organization']);
Route::get('questions/edit/{id}', 'AdminApi\QuestionController@edit')->middleware(['auth:admin','permission:ManageUser','role:Organization']);
Route::apiResource('answers', 'AdminApi\AnswerController')->middleware(['auth:admin','permission:ManageUser','role:Organization']);;


//

Route::apiResource('students','AdminApi\StudentController');

>>>>>>> Stashed changes
