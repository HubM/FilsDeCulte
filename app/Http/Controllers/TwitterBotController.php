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
   		'q' => 'FilsDeCulte'
   	];

    /* Search on twitter all the tweets in relation w/ our bot
    and get the number of them */
   	$allTweets = Twitter::getSearch($parameters);
   	$numberOfTweets = count($allTweets->statuses);

    // Init an empty array of our selected Tweets
    $selectedTweets = [];

   	// check all tweet retourned 
   	for ($tweet=0; $tweet < $numberOfTweets; $tweet++) {

   	    var_dump($allTweets->statuses);
   	    die();

      // get the time of each tweet and convert it to Carbon date format
      $initial_date = $allTweets->statuses[$tweet]->created_at;
      $new_date = Carbon::parse($initial_date);

      // Define the limite time and check if each tweet is inside it or no
      $limit_time = $new_date->diffInMinutes(Carbon::now());

      // Check the source of the tweet
      $source = $allTweets->statuses[$tweet]->user->screen_name;

      $existingTweet = DB::table('tweets')->where('id_tweet', $allTweets->statuses[$tweet]->id_str)->get()->toArray();

      if (!empty($existingTweet)) {
        $error = ['duplicate', $existingTweet];
        $this->sendResponseTweets($error);
        continue;
      }

      if($limit_time <= 60 && $source != BOT_ACCOUNT && empty($existingTweet)) {

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

        // set the boolean isSpoiled to false
        $selectedTweets[$tweet]['isSpoiled'] = 0;


        // Verify we have only one movie as hashtag and get it
        if(count($allTweets->statuses[$tweet]->entities->hashtags) === 1) {
         $selectedTweets[$tweet]['movie'] = $allTweets->statuses[$tweet]->entities->hashtags[0]->text;
        } 

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
          // or set the target to 0
    			} else {
            $selectedTweets[$tweet]['target'] = 0;
          }
    		}

      }   
   	}

    // if our new tweet array has one or more tweet
    if(count($selectedTweets) > 0) {

      /* we call the insert to db method, which will put the tweet content to 
         the database */
       // $this->clearDatabase();
       $this->insertToDatabase($selectedTweets);
       $this->getSpoil($selectedTweets);
    }

   	return view('pages.new-tweets', ['tweets' => $selectedTweets]);
  }

  /*********************
    INSERT THEM IN DB 

  This method first check if the tweet has a target, 
  and then it will put the tweet content to the database

  **********************/
  public function insertToDatabase($array) {
    foreach ($array as $key => $value) {
      if($value["target"] === 0 && $value["movie_title"] != '') {
        continue;
      } else {
        DB::table('tweets')->insertGetId(
          [
            'id_tweet' => $value["id_tweet"], 
            'user_tweet' => $value["user"],
            'tweet_user_id' => $value["user_id"],
            'target_tweet' => $value["target"]["profil"],
            'target_user_id' => $value["target"]["id"],
            'movie_title' => $value["movie"],
            'created_tweet_time' => $value["created_at"],
            'spoil' => '',
            'isSpoiled' => $value['isSpoiled']
          ]
        );
      }
    }
  }

  /***************************************
    GET THE SPOIL FROM THE HASHTAG MOVIE 
  ****************************************/
  public function getSpoil($array) {
    $client = new \AlgoliaSearch\Client('KMJ42U25W4', '1458f0776b9eb5750afc6566782ce6c9');
    $index = $client->initIndex('movies');


    $tweets = DB::table('tweets')->get();
    foreach ($array as $key => $value) {

      foreach ($tweets as $key => $value) {
        $query = (object) $index->search($value->movie_title);

        $reponse = $query->nbHits;

        if($reponse > 0) {
          $spoil = $query->hits[0]["spoil"];

          if(is_array($spoil)) {
            $rand = array_rand($spoil, 1);
            $response = $spoil[$rand];
          } else {
            $response = $spoil;
          }

          DB::table('tweets')->update(
            ['spoil' => $response]
          );
        }
      }

    }
  }

  /*******************
    GIVE A RESPONSE
  ********************/
  public function sendResponseTweets($error) {
    /*
      If an error exist, that's because the tweet
      has already been send, so we tweet the creator
      that the response the request has been made.
    */
    if(!empty($error)){
      $message = 'Il est possible que la réponse est déjà été envoyé. Merci de réessayer plus tard.';
      $target_name = $error[1][0]->user_tweet;
      $parameters_message_target = [
          'status' =>  '@'.$target_name. ' '.$message
        ];

        Twitter::postTweet($parameters_message_target);
    } else {
      $tweets = DB::table('tweets')->get();
       /*
        For each tweet, if this has the boolean 
        isSpoiled set to 0, we define the target account id, 
        the target name and get the spoil.
      */
      foreach ($tweets as $key => $value) {
        if($value->isSpoiled == 0) {

          $target_id = $value->target_user_id;
          $target_name = $value->target_tweet;
          $spoil = $value->spoil;

          /*
            Then we build the spoil and send it via the 
            Twitter API function postTweet()
          */
          $parameters_message_target = [
            'status' =>  '@'.$target_name. ' #'.$value->movie_title. ' ' .$spoil
          ];

          Twitter::postTweet($parameters_message_target);

          /*
            We finally update the boolean isSpoiled in our DB
          */
          DB::table('tweets')->where('id', '=', $value->id)->update(['isSpoiled' => 1]);

        } else {
          continue;
        }
      }
    }
    return view('pages.response-tweets');
  }



}
