<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

define("BOT_ACCOUNT", 'FilsDeCulte');
define("LIMIT_TIME", 200);

class Tweet extends Model
{

		/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tweets';


    public static function isEligible($singleTweet) {

   		// get the time of each tweet and convert it to Carbon date format
    	$initial_date = $singleTweet->created_at;

    	// dd($initial_date);
    	$new_date = Carbon::parse($initial_date);

  	  // Define the limite time and check if each tweet is inside it or no
    	$limit_time = $new_date->diffInMinutes(Carbon::now());

    	// Check the source of the tweet
    	$source = $singleTweet->user->screen_name;

    	// We verify that the tweet contain a hashtag 
    	$hashtags = count($singleTweet->entities->hashtags);


    	// We verify that the tweet mentionned exactly two people
    	$userMentions = count($singleTweet->entities->user_mentions);

    	// We check in the database if the tweet already exist
	    $existingTweet = self::where('id_tweet', $singleTweet->id_str)->exists();	


	    /*
				If the tweet is insside the defined time && it doesn't come from
				our bot && it has exactly one hashtag (one movie) && it doesn't exist 
				in our db, we return true, which means that the tweet is elligible
	    */
      if($limit_time <= LIMIT_TIME && 
      		$source != BOT_ACCOUNT && 
      		$hashtags === 1 && 
      		$userMentions === 2 &&
      		!$existingTweet
      	) {
				return true;
      } 

    }

    public static function insertTweetInDatabase($singleTweet) {

    	// dd($singleTweet);

    	$tweet = new Tweet;

    	$tweet->id_tweet = $singleTweet['id_tweet'];
    	$tweet->user_tweet =  $singleTweet['user'];
    	$tweet->tweet_user_id = $singleTweet['user_id'];
    	$tweet->target_tweet =  $singleTweet['target']['profil'];
    	$tweet->target_user_id = $singleTweet['target']['id'];
    	$tweet->movie_title = $singleTweet['movie'];
    	$tweet->created_tweet_time = $singleTweet['created_at'];
    	$tweet->spoil = '';
    	$tweet->isSpoiled = $singleTweet['isSpoiled'];
      $tweet->isFailed = 0;

    	$tweet->save();
    }
}
