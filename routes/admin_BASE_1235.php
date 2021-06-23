<?php

use Illuminate\Http\Request;

Route::apiResource('users', 'AdminApi\UserController')->middleware(['auth:admin','permission:ManageUser','role:Organization']);;;
Route::apiResource('roles', 'AdminApi\RoleController')->middleware(['auth:admin','permission:ManageUser','role:Organization']);;
Route::apiResource('permissions', 'AdminApi\PermissionController')->middleware(['auth:admin','permission:ManageUser','role:Organization']);;;
Route::apiResource('quizzes', 'AdminApi\QuizController')->middleware(['auth:admin','permission:ManageUser','role:Organization']);;;

// Route::apiResource('blogs', 'BlogController')->middleware('auth');

// Route::post('blogs/{blog}/update-image', 'BlogController@updateFeaturedImage')->middleware('auth');

// Route::apiResource('categories', 'CategoryController')->middleware('auth');
Route::get('activities/{userId?}', 'AdminApi\ActivityController@index'); 


Route::apiResource('questions', 'AdminApi\QuestionController');
Route::apiResource('answers', 'AdminApi\AnswerController');