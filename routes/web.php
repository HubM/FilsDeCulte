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

// Route::get('/', function(){
// 	return view('welcome');
// });

Route::get('/', function() {
	return view('pages.hello');
});


Route::get('/our-stats', 'StatsController@getStats');

// Route::get('/new-tweets', 'TwitterBotController@getNewTweets');

// Route::get('/response-tweets', 'TwitterBotController@sendResponseTweets');
