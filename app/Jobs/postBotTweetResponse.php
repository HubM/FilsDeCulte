<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use \App\Tweet;
use Twitter;

class postBotTweetResponse implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


  protected $tweet_id;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct(string $tweet_id)
  {
    $this->tweet_id = $tweet_id;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    /*
      We find the tweet by its unique id and if it hasn't been spoiled,
      we build a response which contain the target name, the movie and the spoil 
    */
    $tweet = Tweet::where('id_tweet', $this->tweet_id);
    $tweet_id = $tweet->first()->id_tweet;

    if($tweet->first()->isSpoiled == 0) {
      $target_id = $tweet->first()->target_user_id;
      $target_name = $tweet->first()->target_tweet;
      $spoil = $tweet->first()->spoil;
      $movie = $tweet->first()->movie_title;

      $parameters_message_target = [
        'status' =>  "Désolé @$target_name mais dans #$movie, $spoil",
        'in_reply_to_status_id' => $tweet_id
      ];

      Twitter::postTweet($parameters_message_target);

      /*
        We finally set the isSpoiled boolean to 1, like that this tweet will never be spoiled again :D
      */      
      $tweet->update(['isSpoiled' => 1]);

    } else {
      /*
        If the tweet has the isSpoiled boolean at 1, we technically should never seen this error
        beccause the tweet should not be selected by the isElligible function (Tweet model).
        We have decided to make a second verficiation here, and if the tweet exist already with a isSpoiled to 1, we simply display this error and die the script 
      */
      exit("the tweet with the id n°$tweet_id has already been spoiled");
    }
    
  }
}
