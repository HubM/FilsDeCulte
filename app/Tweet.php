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


    // var_dump($table)

    public static function isEligible($singleTweet) {

   		// get the time of each tweet and convert it to Carbon date format
    	$initial_date = $singleTweet->created_at;

    	// dd($initial_date);
    	$new_date = Carbon::parse($initial_date);

  	  // Define the limite time and check if each tweet is inside it or no
    	$limit_time = $new_date->diffInMinutes(Carbon::now());

    	// Check the source of the tweet
    	$source = $singleTweet->user->screen_name;

    	$hashtags = count($singleTweet->entities->hashtags);

	    $existingTweet = self::where('id_tweet', $singleTweet->id_str)->exists();	

      if($limit_time <= LIMIT_TIME && 
      		$source != BOT_ACCOUNT && 
      		$hashtags === 1 && 
      		!$existingTweet
      	) {
    				return true;
      } 

       //  if (!empty($existingTweet)) {
       //  	$error = ['duplicate', $existingTweet];
       //  	$this->sendResponseTweets($error);
       //  	continue;
      	// }
	   	// 	var_dump($tweet);

    	// }

    	// print_r($selectedTweets);

    }

   //  function isEligible($allTweets){



	  //     // get the time of each tweet and convert it to Carbon date format
	  //     $initial_date = $allTweets->statuses[$tweet]->created_at;
	  //     $new_date = Carbon::parse($initial_date);

	  //     // Define the limite time and check if each tweet is inside it or no
	  //     $limit_time = $new_date->diffInMinutes(Carbon::now());

	  //     // Check the source of the tweet
	  //     $source = $allTweets->statuses[$tweet]->user->screen_name;

	  //     $existingTweet = DB::table('tweet')->where('id_tweet', $allTweets->statuses[$tweet]->id_str)->get()->toArray();


	  //     if (!empty($existingTweet)) {
	  //       $error = ['duplicate', $existingTweet];
	  //       $this->sendResponseTweets($error);
	  //       continue;
	  //     }

	  //     if($limit_time <= 60 && $source != BOT_ACCOUNT && empty($existingTweet)) {

	  //       // get the tweet reference id
	  // 		  $selectedTweets[$tweet]['id_tweet'] = $allTweets->statuses[$tweet]->id_str;

	  // 		  // get the author of the tweet
	  // 		  $selectedTweets[$tweet]['user'] = $allTweets->statuses[$tweet]->user->screen_name;

	  //       // get the id of the tweet author
	  //       $selectedTweets[$tweet]['user_id'] = $allTweets->statuses[$tweet]->user->id_str;

	  // 		  // get the profil pic of the author
	  // 		  $selectedTweets[$tweet]['user_profile'] = $allTweets->statuses[$tweet]->user->profile_image_url_https;
	            
	  //       // get the time where the tweet has been created
	  //       $selectedTweets[$tweet]['created_at'] = $new_date->toTimeString();

	  //       // set the boolean isSpoiled to false
	  //       $selectedTweets[$tweet]['isSpoiled'] = 0;


	  //       // Verify we have only one movie as hashtag and get it
	  //       if(count($allTweets->statuses[$tweet]->entities->hashtags) === 1) {
	  //        $selectedTweets[$tweet]['movie'] = $allTweets->statuses[$tweet]->entities->hashtags[0]->text;
	  //       } 

	  //   		// Check all users mentionned and eject FilsDeCulte
	  //   		foreach ($allTweets->statuses[$tweet]->entities->user_mentions as $key => $value) {

	  //   			if($value->name != BOT_ACCOUNT) {
	  //   				$target = $allTweets->statuses[$tweet]->entities->user_mentions[$key]->screen_name;
	  //           $target_id = $allTweets->statuses[$tweet]->entities->user_mentions[$key]->id_str;

	  //   				$selectedTweets[$tweet]['target'] = [
	  //             'status' => 1,
	  //             'id' => $target_id,
	  //             'profil' =>$target,
	  //           ];
	  //         // or set the target to 0
	  //   			} else {
	  //           $selectedTweets[$tweet]['target'] = 0;
	  //         }
	  //   		}

	  //     }   
	  //  	}

	  //   // if our new tweet array has one or more tweet
	  //   if(count($selectedTweets) > 0) {

	  //     /* we call the insert to db method, which will put the tweet content to 
	  //        the database */
	  //      // $this->clearDatabase();
	  //      $this->insertToDatabase($selectedTweets);
	  //      $this->getSpoil($selectedTweets);
	  //   }

	  //  	return view('pages.new-tweets', ['tweets' => $selectedTweets]);
	  // }

}
