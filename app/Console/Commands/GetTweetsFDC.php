<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Twitter;
use Illuminate\Support\Facades\DB;

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
        $numberOfTweets = count($allTweets->statuses);


        print_r($allTweets);
        //Init an empty array of our selected Tweets
        //$selectedTweets = [];
    }
}
