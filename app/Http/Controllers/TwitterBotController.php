<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twitter;
use Carbon\Carbon;

define("BOT_ACCOUNT", 'FilsDeCulte');

class TwitterBotController extends Controller
{
   public function getAllTweets() {

   	$parameters = [
   		'q' => 'filsdeculte',
   		'count' => 20,
   	];

   	$allTweets = Twitter::getSearch($parameters);

   	$numberOfTweets = count($allTweets->statuses);


   	$current_time = Carbon::now()->toDateTimeString();


   	print_r($current_time);



   	// print_r($numberOfTweets);
   	$selectedTweets = [];

   	// check all tweet retourned 
   	for ($tweet=0; $tweet < $numberOfTweets; $tweet++) { 




   		// get the tweet reference id
   		$selectedTweets[$tweet]['id_tweet'] = $allTweets->statuses[$tweet]->id_str;

   		// get the author of the tweet
   		$selectedTweets[$tweet]['user'] = $allTweets->statuses[$tweet]->user->screen_name;

   		// get the profil pic of the author
   		$selectedTweets[$tweet]['user_profile'] = $allTweets->statuses[$tweet]->user->profile_image_url_https;

   		// Check all users mentionned and eject FilsDeCulte
   		foreach ($allTweets->statuses[$tweet]->entities->user_mentions as $key => $value) {
   			if($value->name != BOT_ACCOUNT) {
   				$target = $allTweets->statuses[$tweet]->entities->user_mentions[$key]->screen_name;
   				$selectedTweets[$tweet]['target'] = $target;
   			}
   		}

   		// Verify we have only one movie as hashtag and get it
   		if(count($allTweets->statuses[$tweet]->entities->hashtags[0]) == 1) {
	   		$selectedTweets[$tweet]['movie'] = $allTweets->statuses[$tweet]->entities->hashtags[0]->text;
   		}

   		$initial_date = $allTweets->statuses[$tweet]->created_at;
   		$new_date = Carbon::parse($initial_date);
   		echo "<pre>";
   		print_r($new_date->date);   		


   	}

   	// echo "<pre>";
   	// 	print_r($selectedTweets);
   	die();
   	return view('all-tweets')->with('tweets', $selectedTweets);
   }
}
