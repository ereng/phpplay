<?php

namespace App\Console\Commands;

use DB;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use GuzzleHttp\Exception\ClientException;

class TPAAccessGet extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'tpa:get';

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
    try {
      if (\App\ThirdPartyApp::where('email','ml4afrika@play.dev')->count()>0) {
        $get = $this->get();
      }else{
        dd('kindly post access credentials in to etc');
      }
    } catch (\GuzzleHttp\Exception\ClientException $e) {

      $this->login();
    }
  }


  public function login()
  {
    // status 401
    echo "Log In\n";
    $clientLogin = new Client();
    // send results for individual tests for starters
    // $loginResponse = $clientLogin->request('POST', 'http://blis3.local/api/login', [
    $loginResponse = $clientLogin->request('POST', 'http://192.168.134.53/api/login', [
      'headers' => [
        'Accept' => 'application/json',
        'Content-type' => 'application/json'
      ],
      'json' => [
        'username' => 'admin@blis.local',
        'password' => 'password'
      ],
    ]);

    if ($loginResponse->getStatusCode() == 200) {
// dd($loginResponse->getBody()->getContents());
      $accessToken = json_decode($loginResponse->getBody()->getContents())->token;
      \App\ThirdPartyApp::where('email','ml4afrika@play.dev')->update(['access_token' => $accessToken]);

      $get = $this->get();

      if ($testRequest->getStatusCode() == 200) {
        dd($testRequest->getBody()->getContents());

      }else{
        dd('real problem up in here');
      }
    }
  }

  public function get()
  {
    $accessToken = \App\ThirdPartyApp::where('email','ml4afrika@play.dev')->first()->access_token;

    $client = new Client();

    // $response = $client->request('GET', 'http://blis3.local/api/tpa/thirdpartyapp', [
    $response = $client->request('GET', 'http://192.168.134.53/api/tpa/thirdpartyapp', [
      'headers' => [
        'Accept' => 'application/json',
        'Content-type' => 'application/json',
        'Authorization' => 'Bearer '.$accessToken,
      ],
    ]);
    dd(json_decode($response->getBody()->getContents()));
    return $response;
  }
}
