<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Tweet;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


define('LIMIT_TWEETS_TODAY',5);

class StatsController extends Controller
{
  public function getStats() {

		/* 
			Initialisation
			--------
			We first create an empty array datas which will contain all the 
			informations we need. 
			The array $tweets get all the tweets from the datab
  	*/
  	$datas = [];
  	$tweets = Tweet::get();

  	/* 
			Global number of tweets
			--------
  	*/
  	$count_tweets = count($tweets);
  	$datas['all_tweets'] = $count_tweets;

		/* 
			Number of tweets spoiled && failed &&
			get the number of tweet made today
			--------
  	*/
  	$counterSpoil = 0;
  	$counterFailed = 0;
  	$counterDailyTweets = 0;
  	$daily_tweets = [];
  	foreach ($tweets as $key => $value) {  	
  		$tweet_date = Carbon::parse($value->created_at);

  		if($tweet_date->isToday()){
  			$counterDailyTweets++;
  			if($key <= LIMIT_TWEETS_TODAY){
					$daily_tweets[$key] = $value;
  			}
  		}

  		if($value->isSpoiled) {
  			$counterSpoil++;
  		}

  		if($value->isFailed) {
  			$counterFailed++;
  		}
  	}

  	$datas['counter_tweets_spoiled'] = $counterSpoil;
  	$datas['counter_tweets_failed'] = $counterFailed;
  	$datas['counter_daily_tweets'] = $counterDailyTweets;
  	$datas['daily_tweets'] = $daily_tweets;
  	
  	/* 
			Get best spoiler
			--------
  	*/
  	$query_best_spoiler = Tweet::select(DB::raw("user_tweet, count(user_tweet) as best_spoiler"))
			->groupBy('user_tweet')
			->orderBy("best_spoiler",'desc')
			->limit(1)
			->get();

		$best_spoiler = $query_best_spoiler[0]->user_tweet;
		$datas['best_spoiler'] = $best_spoiler;

  	/* 
			Get best movie
			--------
  	*/
		$query_best_movies = Tweet::select(DB::raw("movie_title, count(movie_title) as best_movies"))
			->groupBy('movie_title')
			->orderBy("best_movies",'desc')
			->limit(1)
			->get();

		$best_movie = $query_best_movies[0]->movie_title;
		$datas['best_movie'] = $best_movie;

		return view('pages.statistics')->with('datas', $datas);	
  }
}
