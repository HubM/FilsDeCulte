<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class addSpoilToAlgoliaCollectionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $spoil;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(object $spoil)
    {
        $this->spoil = $spoil;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new \AlgoliaSearch\Client('KMJ42U25W4', 'fe5cb99857161f277a1c9b21199cf8e4');
        $index  = $client->initIndex('movies');

        $add_spoil = [
            'movie' => $this->spoil->movie,
            'spoil' => $this->spoil->spoil
        ];

        $index->addObject($add_spoil);
    }
}
