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

Route::get('/help-us', function() {
	return view('pages.help-us');
});


Route::post('/help-us', 'HelpUsController@getHelpSpoil');

Route::get('/our-stats', 'StatsController@getStats');