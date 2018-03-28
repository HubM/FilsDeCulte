<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Tweet;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class StatsController extends Controller
{
  public function getStats() {

  	$tweets = Tweet::get();

	  /*
			Variables pour gestion des tweets échouées
			--------

  		$failedTweets = Tweet::where('isFailed', 1);
  		$get_failedTweets = $failedTweets->get();
  		$count_failedTweets = $failedTweets->count();
		*/

  	/*
			Variables pour connaitre le meilleur spoiler
			---------
	  	$query_best_spoiler = Tweet::select(DB::raw("user_tweet, count(user_tweet) as best_spoiler"))
	  												 							->groupBy('user_tweet')
	  												 							->orderBy("best_spoiler",'desc')
	  												 							->limit(2)
	  												 							->get();

  		$best_spoiler = $query_best_spoiler[0]->user_tweet;
  	*/

  	/*
			Variables pour obtenir les tweets du jours et leur nombre
			---------
	  	foreach ($tweets as $tweet => $value) {
	  		$tweet_date = Carbon::parse($value->created_at);

	  		if($tweet_date->isToday()) 
	  			$today_tweets[$tweet] = $value;
	  	}

	  	$today_tweets - Les tweets du jours;
	  	$nb_today_tweets = count($today_tweets); - Le nombre de tweet du jour
  	*/

	  /*
			Variables pour obtenir le films le plus tweeté
			---------

			$query_best_movies = Tweet::select(DB::raw("movie_title, count(movie_title) as best_movies"))
  												 							->groupBy('movie_title')
  												 							->orderBy("best_movies",'desc')
  												 							->limit(1)
  												 							->get();

			$best_movie = $query_best_movies[0]->movie_title;
	  */
		return view('pages.statistics');	
  }
}
