<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

// Auth routes
Auth::routes(['verify' => true, 'register' => false]);
Route::get('/logout', 'Auth\LoginController@logout');

// Home
Route::get('/', 'PageController@index')->name('page.home');

// Pages
Route::get('/angebot', 'PageController@services')->name('page.services');
Route::get('/themen', 'PageController@topics')->name('page.topics');
Route::get('/veranstaltungen', 'PageController@events')->name('page.events');
Route::get('/veranstaltungen/anmeldung-erfolgreich', 'PageController@thankYou')->name('page.events.thank-you');
Route::get('/ueber-uns', 'PageController@about')->name('page.about');
Route::get('/team', 'PageController@team')->name('page.team');
Route::get('/netzwerk', 'PageController@network')->name('page.network');
Route::get('/blog', 'PageController@blog')->name('page.blog');
Route::get('/agb', 'PageController@toc')->name('page.toc');
Route::get('/kontakt', 'PageController@contact')->name('page.contact');

// Url based images
Route::get('/img/{template}/{filename}', 'ImageController@getResponse');

/*
|--------------------------------------------------------------------------
| Admin Web routes
|--------------------------------------------------------------------------
|
*/

Route::middleware('auth:sanctum', 'verified')->group(function() {

  // CatchAll: Dashboard Administration
  Route::get('administration/{any?}', function () {
    return view('dashboards.administration.app');
  })->where('any', '.*')->middleware('role:admin')->name('dashboard_admin');

});
