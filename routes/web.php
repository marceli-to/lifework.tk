<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public web routes
|--------------------------------------------------------------------------
|
*/

// Auth
Auth::routes(['verify' => true, 'register' => false]);
Route::get('/logout', 'Auth\LoginController@logout');

// Pages
Route::get('/', 'PageController@index')->name('page.home');
Route::get('/angebot', 'PageController@services')->name('page.services');
Route::get('/themen', 'PageController@topics')->name('page.topics');
Route::get('/ueber-uns', 'PageController@about')->name('page.about');
Route::get('/team', 'PageController@team')->name('page.team');
Route::get('/partner', 'PageController@partner')->name('page.partner');
Route::get('/blog', 'PageController@blog')->name('page.blog');
Route::get('/agb', 'PageController@toc')->name('page.toc');
Route::get('/kontakt', 'PageController@contact')->name('page.contact');

// Page: Events
Route::get('/veranstaltungen', 'EventController@index')->name('page.events');

// Url based images
Route::get('/img/{template}/{filename}', 'ImageController@getResponse');

/*
|--------------------------------------------------------------------------
| Authenticated web routes
|--------------------------------------------------------------------------
|
*/

Route::middleware('auth:sanctum', 'verified')->group(function() {

  // CatchAll: Dashboard Administration
  Route::get('administration/{any?}', function () {
    return view('dashboards.administration.app');
  })->where('any', '.*')->middleware('role:admin')->name('dashboard_admin');

});
