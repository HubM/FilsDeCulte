<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twitter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

define("BOT_ACCOUNT", 'FilsDeCulte');

class TwitterBotController extends Controller
{

  /**************
    GET TWEETS  
  ***************/
  public function getNewTweets() {
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

      if($limit_time <= 90) {

  		  // get the tweet reference id
  		  $selectedTweets[$tweet]['id_tweet'] = $allTweets->statuses[$tweet]->id_str;

  		  // get the author of the tweet
  		  $selectedTweets[$tweet]['user'] = $allTweets->statuses[$tweet]->user->screen_name;

        // get the id of the tweet author
        $selectedTweets[$tweet]['user_id'] = $allTweets->statuses[$tweet]->user->id_str;

  		  // get the profil pic of the author
  		  $selectedTweets[$tweet]['user_profile'] = $allTweets->statuses[$tweet]->user->profile_image_url_https;
            
        // get the time where the tweet has been created
        $selectedTweets[$tweet]['created_at'] = $new_date->toTimeString();

    		// Check all users mentionned and eject FilsDeCulte
    		foreach ($allTweets->statuses[$tweet]->entities->user_mentions as $key => $value) {
    			if($value->name != BOT_ACCOUNT) {
    				$target = $allTweets->statuses[$tweet]->entities->user_mentions[$key]->screen_name;
            $target_id = $allTweets->statuses[$tweet]->entities->user_mentions[$key]->id_str;

    				$selectedTweets[$tweet]['target'] = [
              'status' => 1,
              'id' => $target_id,
              'profil' =>$target,
            ];
    			} else {
            $selectedTweets[$tweet]['target'] = 0;
          }
    		}

    		// Verify we have only one movie as hashtag and get it
    		if(count($allTweets->statuses[$tweet]->entities->hashtags[0]) == 1) {
 	   		 $selectedTweets[$tweet]['movie'] = $allTweets->statuses[$tweet]->entities->hashtags[0]->text;
 		    }
		
      }
   	}

    // if our array of tweet has more than one tweet, 
    // for each tweet, we will verify if a target is present, 
    // and if it's good, we push it in the tweet table
    if(count($selectedTweets) > 0) {
       $this->insertToDatabase($selectedTweets);
    }

   	return view('pages.new-tweets', ['tweets' => $selectedTweets]);
  }

  /*********************
    INSERT THEM IN DB 
  **********************/
  public function insertToDatabase($array) {
    foreach ($array as $key => $value) {
      if($value["target"] === 0) {
        continue;
      } else {
        DB::table('tweet')->insertGetId(
          [
            'id_tweet' => $value["id_tweet"], 
            'user_tweet' => $value["user"],
            'tweet_user_id' => $value["user_id"],
            'target_tweet' => $value["target"]["profil"],
            'target_user_id' => $value["target"]["id"],
            'movie_title' => $value["movie"],
            'created_tweet_time' => $value["created_at"]
          ]
        );
      }
    }
  }

  /*******************
    GIVE A RESPONSE
  ********************/
  public function sendResponseTweets() {
    $tweets = DB::table('tweet')->get();

    $target_id = $tweets[0]->target_user_id;
    $target_name = $tweets[0]->target_tweet;

    // Tweet to the target
    $parameters_message_target = [
      'status' => "@".$target_name.' Ils y arrivent mais 3 meurent'
    ];

    Twitter::postTweet($parameters_message_target);

    return view('pages.response-tweets');
  }
}