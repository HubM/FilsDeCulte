<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use \App\Tweet;
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

    /*
      We verify that we have a response, 
      if this response is an array with multiple spoil,
      we make a random on this array and pick one result
    */
    if($query->nbHits > 0) {
      $spoil = $query->hits[0]["spoil"];
      
      if(is_array($spoil)) {
        $rand = array_rand($spoil, 1);
        $response = $spoil[$rand];
      } else {
        $response = $spoil;
      }

      /*
        we get the final spoil, and update in our database the tweet associated
      */
      Tweet::where('id_tweet', $this->tweet)->update(['spoil' => $response]);


    } else {
      /*
        if we haven't a spoil for this movie, we stop the processus and display a message (tmp)
      */
      dd('THERE IS NO SPOIL FOR YOUR MOVIE, SORRY BRO');
    }

  }


}
