<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Storage;
// use Goutte\Client;

use Illuminate\Console\Command;

class GetScrap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get spoils with the scrap of etenfaitalafin.fr ';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public function __construct()
    {
        parent::__construct();
    }

    //Scraping site map of spoilme.io
    // public function scrapMap (){
    //     $map = [];
    //     $content = file_get_contents('https://spoilme.io/sitemap.xml');
    //     $xml = simplexml_load_string($content);
    //     foreach ($xml as $url) {
    //         $text = (string)$url->loc;
    //         if (strpos($text, '/fr/') !== false && strpos($text, '/movies/') !== false) {
    //             array_push($map, $text);
    //         }
    //     }
    //     $json = json_encode($map);
    //     Storage::put('data_sitemap.json', $json);
    // }
    //Scraping spoil in each url of sitemap of spoilme.io
    // public function scrapSpoilme ($arrayScrap){
    //     $map = $arrayScrap = json_decode(\Storage::get('data_sitemap.json'),true);
    //     foreach ($map as $url) {
    //         $client = new Client();
    //         $guzzleClient = new \GuzzleHttp\Client(array(
    //             'timeout' => 10000,
    //             'verify' => false,
    //         ));
    //         $client->setClient($guzzleClient);
    //
    //         $crawler = $client->request('GET', $url, ['timeout' => 1000]);
    //         $crawler->filter('title')->each(function ($node) {
    //             print("\n\n".$node->text()."\n");
    //             $scrap = $node->text();
    //         });
    //
    //         break;
    //     }
    // }

    public function getAlgolia() {
        $tab = [];
        $client = new \AlgoliaSearch\Client('KMJ42U25W4', 'fe5cb99857161f277a1c9b21199cf8e4');
        $index  = $client->initIndex('movies');
        $query = (object) $index->search('');
        foreach ($query->hits as $key) {
            array_push($tab, ['movie'=>$key['movie'], 'spoil'=>$key['spoil']]);
        }
        return($tab);
    }

    public function addToAlgolia($scrap) {
        $client = new \AlgoliaSearch\Client('KMJ42U25W4', 'fe5cb99857161f277a1c9b21199cf8e4');
        $index  = $client->initIndex('movies');

        $add_spoil = [
            'movie' => $scrap['movie'],
            'spoil' => $scrap['spoil']
        ];

        $index->addObject($add_spoil);
    }

    public function parseHTML ($url, $targets) {
        $content = file_get_contents($url);
        $html= new \DOMDocument();
        $html->loadHTML($content);
        $scrap = [];
        foreach ($targets as $target) {
            $result = $html->getElementsByTagName($target);
            $result = $result->item(0)->textContent;
            array_push($scrap, $result);
        }
        return $scrap;
    }

    public function verifyData ($scrap, $arrayScrap){
        foreach ($arrayScrap as $data_film) {
            if($data_film['movie'] == $scrap['movie']){
                return $arrayScrap;
            }
        }
        //add spoil to algolia and arrayScrap (for testing)
        print("\n" . 'New movie : ' . $scrap['movie']);
        $this->addToAlgolia($scrap);
        array_push($arrayScrap, $scrap);
        return $arrayScrap;
    }

    public function scrapEtenfait ($ite=200, $arrayScrap){

        for ($n=0; $n < $ite ; $n++) {

            //get url redirection
            libxml_use_internal_errors(true);
            $redirect = $this->parseHTML('http://etenfaitalafin.fr/',['script']);
            $redirect = 'http://etenfaitalafin.fr' . explode("'", $redirect[0])[1];

            //get spoiler
            $scrap = $this->parseHTML($redirect, ['p', 'title']);
            $spoil = 'A la fin' . explode("à la fin,", $scrap[0])[1];
            $title = explode(" - Et en fait", $scrap[1])[0];
            $scrap = ['movie'=>$title, 'spoil'=>$spoil];

            //verify if scrap not in array
            $arrayScrap = $this->verifyData($scrap, $arrayScrap);

            //sleep
            sleep(rand(0, 1));
        }
        return($arrayScrap);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        print('---STARTING THE SCRAP---');

        //get array of spoils from algolia
        $arrayScrap = $this->getAlgolia();

        //get new spoil from etenfaitalafin.fr
        $arrayScrap = $this->scrapEtenfait(20,$arrayScrap);

        print("\n".'---FINISHING THE SCRAP---');
    }
}
