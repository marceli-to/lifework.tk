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

  // Upload
  Route::post('image/upload','Api\UploadController@image');
  Route::post('file/upload','Api\UploadController@file');
  Route::get('files/get','Api\UploadController@getFiles');

  // // About
  // Route::get('about', 'Api\AboutController@get');
  // Route::get('about/{about}', 'Api\AboutController@find');
  // Route::post('about', 'Api\AboutController@store');
  // Route::put('about/{about}', 'Api\AboutController@update');
  // Route::get('about/state/{about}', 'Api\AboutController@toggle');
  // Route::delete('about/{about}', 'Api\AboutController@destroy');

  // // About images
  // Route::get('about/image/state/{aboutImage}', 'Api\AboutImageController@toggle');
  // Route::put('about/image/{aboutImage}', 'Api\AboutImageController@coords');
  // Route::post('about/image/order', 'Api\AboutImageController@order');
  // Route::post('about/image', 'Api\AboutImageController@store');
  // Route::delete('about/image/{aboutImage}', 'Api\AboutImageController@destroy');


});

