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

  // Post images
  Route::get('post/images/{post}', 'Api\PostImageController@get');
  Route::get('post/image/state/{postImage}', 'Api\PostImageController@toggle');
  Route::put('post/image/{postImage}', 'Api\PostImageController@coords');
  Route::post('post/image', 'Api\PostImageController@store');
  Route::post('post/image/order', 'Api\PostImageController@order');
  Route::delete('post/image/{postImage}', 'Api\PostImageController@destroy');

  // Post
  Route::get('post', 'Api\PostController@get');
  Route::get('post/{post}', 'Api\PostController@find');
  Route::post('post', 'Api\PostController@store');
  Route::put('post/{post}', 'Api\PostController@update');
  Route::get('post/state/{post}', 'Api\PostController@toggle');
  Route::delete('post/{post}', 'Api\PostController@destroy');

  // Testimonial
  Route::get('testimonials', 'Api\TestimonialController@get');
  Route::get('testimonial/{testimonial}', 'Api\TestimonialController@find');
  Route::post('testimonial', 'Api\TestimonialController@store');
  Route::put('testimonial/{testimonial}', 'Api\TestimonialController@update');
  Route::get('testimonial/state/{testimonial}', 'Api\TestimonialController@toggle');
  Route::post('testimonials/order', 'Api\TestimonialController@order');
  Route::delete('testimonial/{testimonial}', 'Api\TestimonialController@destroy');

  // Upload
  Route::post('image/upload','Api\UploadController@image');
  Route::post('file/upload','Api\UploadController@file');
  Route::get('files/get','Api\UploadController@getFiles');
  
});

// Register endpoint
Route::post('register', 'Api\RegisterController@store');


