<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use \App\Tweet;
use Twitter;

use \App\Jobs\connectAlgoliaAndGetSpoilJob;
use \App\Jobs\postBotTweetResponseJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

use Carbon\Carbon;
// use \App\Http\Controllers\getSpoilFromAlgoliaController;


// define("BOT_ACCOUNT", 'FilsDeCulte');

class GetTweetsFDC extends Command
{

   use DispatchesJobs;
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

        foreach ($allTweets->statuses as $key => $tweet) {
          /* For each tweet, we check if the model Tweet validate our tweet, 
          and add it to the selectedTweets array */          
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
            If there are not two user mentionned, we stop the current tweet verification and go to
            the next.
            */
            $userMentions = $tweet->entities->user_mentions;

            foreach ($userMentions as $id => $value) {
              if($value->name != BOT_ACCOUNT) {
                $target_id = $value->id_str;
                $target = $value->screen_name;
                $selectedTweets[$key]['target'] = [
                  'id' => $target_id,
                  'profil' =>$target,
                ];
                break;
              }
            }  

            /*
              Then we call the method to insert the tweet in our database,
              with a empty spoil and a boolean isSpoiled set up at false
            */
            Tweet::insertTweetInDatabase($selectedTweets[$key]);

            /* 
              We create a new instance of our connectAlgoliaAndGetSpoilJob which will create a connection
              to Algolia and get a spoil. This spoil is then updated in our mysql db, associated to it's tweet.
            */
            $identifiant_tweet = $selectedTweets[$key]['id_tweet'];
            $movie = $selectedTweets[$key]['movie'];

            $algoliaJob = new connectAlgoliaAndGetSpoilJob($identifiant_tweet, $movie);
            $this->dispatch($algoliaJob);

            /*
              We create then a new instance of the postBotTweetResponse which will get the spoil and construct
              a tweet for the target. In this one, we tag the target, add an hastag with the movie and finally give 
              the spoil.
              After that, we set the boolean isSpoiled to 1 for this tweet in our database.
            */
            $postResponseJob = (new postBotTweetResponseJob($identifiant_tweet))->delay(Carbon::now()->addSecond(15));
            $this->dispatch($postResponseJob);

            /* 
              If the validation is'nt good, we keep the unconformed tweet to an array,
              and we will push a private message to the author to explain him that his tweet isn't good.
              and give maybe a link to him which explain how to tweet with our bot.
            */
          } else {
            $notSelectedTweets[] = $tweet;
          }
        }



      }
    }
