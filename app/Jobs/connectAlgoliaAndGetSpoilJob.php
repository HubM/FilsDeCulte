<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use \App\Tweet;
use Twitter;


define("URL_HELP", "https://goo.gl/WKrpaq");

class connectAlgoliaAndGetSpoilJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $movie;

  protected $tweet;
  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct(string $tweet , string $movie)
  {
    $this->movie = $movie;   
    $this->tweet = $tweet;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    /*
      We create a connection to Algolia, and we choose the index movies.
      Then, we build a search query with our movie.
    */
    $client = new \AlgoliaSearch\Client('KMJ42U25W4', '1458f0776b9eb5750afc6566782ce6c9');
    $index = $client->initIndex('movies');


    $query = (object) $index->search($this->movie);


    // We make a query to get the current tweet
    $tweet = Tweet::where('id_tweet', $this->tweet);

    /*
      We verify that we have a response, 
      if this response is an array with multiple spoil,
      we make a random on this array and pick one result
    */
    if($query->nbHits > 0) {
      $spoil = $query->hits[0]["spoil"];
      $movie_real_name = $query->hits[0]["movie"];

      
      if(is_array($spoil)) {
        $rand = array_rand($spoil, 1);
        $response = $spoil[$rand];
      } else {
        $response = $spoil;
      }

      /*
        we get the final spoil, and update in our database the tweet associated
      */
      $tweet->update(['spoil' => $response, 'movie_title_real_name' => $movie_real_name]);


    } else {
      /*
        if we haven't a spoil for this movie, we get the tweet and get all
        the necessary informations to build a response on the initial tweet where
        we say that we haven't the message
      */
      $Badtweet = $tweet->first();

      $tweetCreator_tweet_id = $Badtweet->id_tweet; 
      $tweetCreator = $Badtweet->user_tweet;
      $tweetCreator_id = $Badtweet->tweet_user_id;
      $tweetCreator_movie = $Badtweet->movie_title;

      $parametersDirectMessageFail = [
        'status' => "Sorry @$tweetCreator, we doesn't know your movie #$tweetCreator_movie :/. You maybe can help us ? ". URL_HELP,
        'in_reply_to_status_id' => $tweetCreator_tweet_id
      ];
      Twitter::postTweet($parametersDirectMessageFail);


      /*
        Once the tweet has been posted, we initialize the isFailed to 1.
        This Data can be interessant for statistics.
        We finally use exit to stop the execution of the script, and displ
      */
      $tweet->update(['isFailed' => 1]);

      exit("stop the execution of the tweet n°$tweetCreator_tweet_id (spoil not found)");

    }

  }


}
