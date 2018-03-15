<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Twitter;
use Illuminate\Support\Facades\DB;
use \App\Tweet;
use Carbon\Carbon;

// define("BOT_ACCOUNT", 'FilsDeCulte');

class GetTweetsFDC extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tweets:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all the tweets from twitter API';

    /**
     * Create a new command instance.
     * @param string $drip
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $query = 'FilsDeCulte';
        $this->query = $query;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /* Search on twitter all the tweets in relation w/ our bot
        and get the number of them */
        $parameters = [
            'q' => $this->query
        ];        
        $allTweets = Twitter::getSearch($parameters);

        /* For reach tweet, we check if the model Tweet validate our tweet, 
        and add it to the selectedTweets array */
        foreach ($allTweets->statuses as $key => $tweet) {
          if(Tweet::isEligible($tweet)) {
            $selectedTweets[$key]['id_tweet'] = $tweet->id_str;
            $selectedTweets[$key]['user'] = $tweet->user->screen_name;
            $selectedTweets[$key]['user_id'] = $tweet->user->id_str;
            $selectedTweets[$key]['user_profile'] = $tweet->user->profile_image_url_https;
            $selectedTweets[$key]['created_at'] = Carbon::parse($tweet->created_at)->toTimeString();
            $selectedTweets[$key]['isSpoiled'] = 0;
            $selectedTweets[$key]['movie'] = $tweet->entities->hashtags[0]->text;

            /* We get the list of users mentionned and verify if there are two.
            For each of them, we check if it's not our bot. 
            We define then the target and add it to the selectedtweets array.
            */
            $userMentions = $tweet->entities->user_mentions;

            foreach ($userMentions as $id => $value) {
              if($value->name != BOT_ACCOUNT && count($userMentions === 2)) {
                $target_id = $tweet->entities->user_mentions[$key]->id_str;
                $target = $tweet->entities->user_mentions[$id]->screen_name;
                $selectedTweets[$key]['target'] = [
                  'status' => 1,
                  'id' => $target_id,
                  'profil' =>$target,
                ];
                break;
              }
            }

          } else {
            $notSelectedTweets[] = $tweet;
          }

          dd($selectedTweets);
        }







        // $tweets = Tweet::isEligible($allTweets);

        // print_r($tweets);

        // model isEll::dsdlmksl(allTweets)
        //Init an empty array of our selected Tweets
        //$selectedTweets = [];
    }
}
