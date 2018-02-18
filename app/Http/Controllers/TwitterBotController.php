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
   		'q' => ['filsdeculte', 'FilsDeCulte'],
   		'count' => 20,
   	];

      // Search on twitter all the tweets in relation w/ our bot
   	$allTweets = Twitter::getSearch($parameters);

      // Get the number of tweets received
   	$numberOfTweets = count($allTweets->statuses);

      // Create an empty array of our selected Tweets
   	$selectedTweets = [];

   	// check all tweet retourned 
   	for ($tweet=0; $tweet < $numberOfTweets; $tweet++) { 

         // get the time of each tweet and convert it to Carbon date format
         $initial_date = $allTweets->statuses[$tweet]->created_at;
         $new_date = Carbon::parse($initial_date);

         // Define the limite time and check if each tweet is inside it or no
         $limit_time = $new_date->diffInMinutes(Carbon::now());
         if($limit_time <= 15) {

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
		
         }
   	}

   	return view('all-tweets')->with('tweets', $selectedTweets);
   }
}
