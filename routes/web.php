<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
	return view('pages.hello');
});

Route::get('/about', function() {
	return view('pages.about');
});

Route::get('/our-stats', 'StatsController@getStats');

/* Help us form */
Route::get('/help-us', function() {
	return view('pages.help-us');
});
Route::post('/help-us', 'HelpUsController@getHelpSpoil');

/* Manager user spoils */
Route::get('/users-spoil', 'UsersSpoilController@getAllUserSpoils');
Route::post('/users-spoil', 'UsersSpoilController@saveManagedUsersSpoils');



Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
