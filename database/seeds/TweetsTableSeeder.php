<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TweetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$path = "tweets_base_dump.sql";
    	DB::unprepared(file_get_contents($path));
    	$this->command->info('Tweets table seeded!');
    }
}
