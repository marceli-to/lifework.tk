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
Route::get('/bildungskrippen', 'PageController@nursery')->name('page.nursery');
Route::get('/ueber-uns', 'PageController@about')->name('page.about');
Route::get('/team', 'TeamController@index')->name('page.team');
Route::get('/netzwerk', 'NetworkController@index')->name('page.network');
Route::get('/netzwerk/personen', 'NetworkController@members')->name('page.network.members');
Route::get('/netzwerk/organisationen', 'NetworkController@organisations')->name('page.network.organisations');
Route::get('/stimmen', 'TestimonialController@index')->name('page.testimonials');
Route::get('/blog', 'BlogController@index')->name('page.blog');
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
