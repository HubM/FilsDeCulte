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
    $tweet = Tweet::where('id_tweet', $this->tweet_id)->first();

    if($tweet->isSpoiled == 0) {

      $target_id = $tweet->target_user_id;
      $target_name = $tweet->target_tweet;
      $spoil = $tweet->spoil;
      $movie = $tweet->movie_title;

      $parameters_message_target = [
        'status' =>  '@'.$target_name. ' #'.$movie. ' ' .$spoil
      ];

      Twitter::postTweet($parameters_message_target);
    }

    Tweet::where('id_tweet', $this->tweet_id)->update(['isSpoiled' => 1]);


  }
}
