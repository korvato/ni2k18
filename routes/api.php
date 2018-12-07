<?php

use Illuminate\Http\Request;

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
Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::group(['middleware' => 'auth:api'], function(){
Route::post('details', 'API\UserController@details');
Route::post('projects', 'API\ProjectController@save');
Route::put('projects/{id}', 'API\ProjectController@update');
Route::get('projectsTasks/{id}', 'API\ProjectController@projectsTasks');
Route::get('projectsTasks', 'API\ProjectController@index');
Route::post('tasks', 'API\TaskController@save');
Route::get('tasksOfProject/{id}', 'API\TaskController@index');
Route::put('tasks/{id}', 'API\TaskController@update');
Route::post('codes', 'API\CodeController@save');
Route::put('codes/{id}', 'API\CodeController@update');
Route::post('comments', 'API\CommentController@save');
Route::put('comments/{id}', 'API\CommentsController@update');
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});