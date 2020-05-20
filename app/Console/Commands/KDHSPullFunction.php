<?php
namespace App\Console\Commands;

use DB;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use GuzzleHttp\Exception\ClientException;

class KDHSPullFunction extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'kdhs:pull';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Command description';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
      parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
/*
http://api.dhsprogram.com/#/introapi.cfm
https://www.dhsprogram.com/data/available-datasets.cfm

all the 
http://api.dhsprogram.com/rest/dhs/data?countryIds=KE&surveyYear=2014 

*/
    try {


      $client = new Client();

      /*

      $response = $client->request('GET', 'http://api.dhsprogram.com/rest/dhs/data?countryIds=KE&surveyYear=2014 ', [
        'headers' => [
          'Accept' => 'application/json',
          'Content-type' => 'application/json',
        ],
      ]);
      // dd(json_decode($response->getBody()->getContents()));
      // return $response;

      */
      $response = $client->request('GET', 'http://api.dhsprogram.com/rest/dhs/data?countryIds=KE&surveyYear=2014 ', [
        'headers' => [
          'Accept' => 'application/json',
          'Content-type' => 'application/json',
        ],
      ]);

      dd(json_decode($response->getBody()->getContents()));
      // return $response;
    } catch (\GuzzleHttp\Exception\ClientException $e) {
      dd('something is broken');
    }
  }
}
