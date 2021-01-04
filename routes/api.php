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

Route::middleware('auth:sanctum')->group(function() {
  Route::get('user', 'Api\UserController@find');

  // Post
  Route::get('post', 'Api\PostController@get');
  Route::get('post/{post}', 'Api\PostController@find');
  Route::post('post', 'Api\PostController@store');
  Route::put('post/{post}', 'Api\PostController@update');
  Route::get('post/state/{post}', 'Api\PostController@toggle');
  Route::delete('post/{post}', 'Api\PostController@destroy');

  // Upload
  Route::post('image/upload','Api\UploadController@image');
  Route::post('file/upload','Api\UploadController@file');
  Route::get('files/get','Api\UploadController@getFiles');
  
});

