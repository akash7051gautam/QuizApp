<?php

use Illuminate\Http\Request;

Route::group(['middleware'=>['auth:admin','permission:ManageUser','role:Organization']],function(){
    Route::apiResource('users', 'AdminApi\UserController');
    Route::apiResource('roles', 'AdminApi\RoleController');
    Route::apiResource('permissions', 'AdminApi\PermissionController');
    Route::apiResource('quizzes', 'AdminApi\QuizController');
    Route::get('activities/{userId?}', 'AdminApi\ActivityController@index');
    Route::apiResource('questions', 'AdminApi\QuestionController');
    Route::apiResource('answers', 'AdminApi\AnswerController');
    Route::apiResource('users','AdminApi\UserController');
    Route::apiResource('useranswers','AdminApi\UserAnswerController');
    Route::apiResource('students','AdminApi\StudentController');
});