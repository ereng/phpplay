<?php

namespace App\Console\Commands;

use DB;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use GuzzleHttp\Exception\ClientException;

class TPAAccessPost extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'tpa:post';

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
      // status 200
      $post = $this->post();

    } catch (\GuzzleHttp\Exception\ClientException $e) {

      // status 401
      echo "Token Expired\n";
      $clientLogin = new Client();
      // send results for individual tests for starters
      $loginResponse = $clientLogin->request('POST', 'http://192.168.134.53/api/login', [
      // $loginResponse = $clientLogin->request('POST', 'http://blis3.local/api/login', [
        'headers' => [
          'Accept' => 'application/json',
          'Content-type' => 'application/json'
        ],
        'json' => [
          'email' => 'admin@blis.local',
          'password' => 'password'
        ],
      ]);

      if ($loginResponse->getStatusCode() == 200) {

        $accessToken = json_decode($loginResponse->getBody()->getContents())->token;
        \App\ThirdPartyApp::where('email','ml4afrika@play.dev')->update(['access_token' => $accessToken]);

        $post = $this->post();

        if ($testRequest->getStatusCode() == 200) {
          dd($testRequest->getBody()->getContents());

        }else{
          dd('real problem up in here');
        }

      }else{
        dd('real problem up in here');

      }

    }
  }

  public function post()
  {
    $accessToken = \App\ThirdPartyApp::where('email','ml4afrika@play.dev')->first()->access_token;

    $client = new Client();
    $data = [
      'third_party_app_id' => 'af20fc56-ff9b-491a-8282-8ad6915eca74',
      'name' => 'ML4Afrika',
      'email' => 'ml4afrika@emr.dev',
      'login_url' => 'http://192.168.134.53:8080/mhealth4afrika/uaa/oauth/token',
      'result_url' => 'http://192.168.134.53:8080/servicefhir/api/blis',
      // 'login_url' => 'http://156.0.232.88:8080/mhealth4afrika/uaa/oauth/token',
      // 'result_url' => 'http://156.0.232.88:8080/servicefhir/api/blis',
      'username' => 'ClinicManager',
      'password' => 'CM@n@ger2019',
      'grant_type' => 'password',
      'client_id' => 'ilab',
      'client_secret' => '87047e052-e35a-91e4-eaa4-43be9615eb8',
    ];

    // $testRequest = $client->request('POST', 'http://blis3.local/api/tpa/access', [
    $testRequest = $client->request('POST', 'http://192.168.134.53/api/tpa/access', [
      'headers' => [
        'Accept' => 'application/json',
        'Content-type' => 'application/json',
        'Authorization' => 'Bearer '.$accessToken,
      ],
      'json' => $data,
    ]);
    return $testRequest;
  }
}
