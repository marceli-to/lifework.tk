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

  // Files
  Route::get('files','Api\FileController@get');
  Route::get('files/fetch','Api\FileController@fetch');
  Route::get('file/restore','Api\FileController@restore');
  Route::get('file/import/{file}','Api\FileController@import');
  Route::post('file/store','Api\FileController@store');
  Route::delete('file/{file}', 'Api\FileController@destroy');

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

  // Organisation
  Route::get('organisations', 'Api\OrganisationController@get');
  Route::get('organisation/{organisation}', 'Api\OrganisationController@find');
  Route::post('organisation', 'Api\OrganisationController@store');
  Route::put('organisation/{organisation}', 'Api\OrganisationController@update');
  Route::get('organisation/state/{organisation}', 'Api\OrganisationController@toggle');
  Route::post('organisations/order', 'Api\OrganisationController@order');
  Route::delete('organisation/{organisation}', 'Api\OrganisationController@destroy');

  // Member categories
  Route::get('member/categories', 'Api\MemberCategoryController@get');
  Route::get('member/category/{member}', 'Api\MemberCategoryController@find');

  // Member images
  Route::get('member/images/{member}', 'Api\MemberImageController@get');
  Route::get('member/image/state/{memberImage}', 'Api\MemberImageController@toggle');
  Route::put('member/image/{memberImage}', 'Api\MemberImageController@coords');
  Route::post('member/image', 'Api\MemberImageController@store');
  Route::post('member/image/order', 'Api\MemberImageController@order');
  Route::delete('member/image/{memberImage}', 'Api\MemberImageController@destroy');

  // Member files
  Route::get('member/files/{member}', 'Api\MemberFileController@get');
  Route::get('member/file/state/{memberFile}', 'Api\MemberFileController@toggle');
  Route::put('member/file/{memberFile}', 'Api\MemberFileController@coords');
  Route::post('member/file', 'Api\MemberFileController@store');
  Route::post('member/file/order', 'Api\MemberFileController@order');
  Route::delete('member/file/{memberFile}', 'Api\MemberFileController@destroy');

  // Member
  Route::get('member', 'Api\MemberController@get');
  Route::get('member/{member}', 'Api\MemberController@find');
  Route::post('member', 'Api\MemberController@store');
  Route::put('member/{member}', 'Api\MemberController@update');
  Route::get('member/state/{member}', 'Api\MemberController@toggle');
  Route::delete('member/{member}', 'Api\MemberController@destroy');

  // Upload
  Route::post('image/upload','Api\UploadController@image');
  Route::post('file/upload','Api\UploadController@file');
  Route::get('files/get','Api\UploadController@getFiles');
  
});

// Register endpoint
Route::post('register', 'Api\RegisterController@store');


