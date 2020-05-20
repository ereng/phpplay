<?php

namespace App\Console\Commands;

use DB;
use Uuid;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class SanitasCommunication extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'sanitas:conveyance';

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
      $testRequest = $this->testRequest();

    } catch (\GuzzleHttp\Exception\ClientException $e) {
      // status 401
      echo "Token Expired\n";
      $clientLogin = new Client();
      // send results for individual tests for starters
      $loginResponse = $clientLogin->request('POST', 'http://blis3.local/api/tpa/login', [
        'headers' => [
          'Accept' => 'application/json',
          'Content-type' => 'application/json'
        ],
        'json' => [
          'email' => 'sanitas@emr.dev',
          'password' => 'password'
        ],
      ]);

      if ($loginResponse->getStatusCode() == 200) {

        $accessToken = json_decode($loginResponse->getBody()->getContents())->access_token;
        \App\ThirdPartyApp::where('email','sanitas@play.dev')->update(['access_token' => $accessToken]);

        $testRequest = $this->testRequest();

        if ($testRequest->getStatusCode() == 200) {
          dd($testRequest->getBody()->getContents());
        }else{
          dd('real problem up in here');

        }
      }else{
        dd('real problem up in here');

      }
    }catch(Exception $e){
      echo "AGH!";
    }
  }

  public function testRequest()
  {
    $accessToken = \App\ThirdPartyApp::where('email','sanitas@play.dev')->first()->access_token;

    $testType = DB::connection('mysqlblis')->table('test_types')->inRandomOrder()->first();

    $cleint = new Client();

    $data = [
      "patient" => [
        "id" => "SN".Str::random(),
        "name"=> "Coolest Dude in  Town",
        "dateOfBirth"=> "1994-05-30",
        "gender"=> "Male"
      ],
      "address" => [
        "phoneNumber"=>"+777 7777 777 777",
        "address"=>"Coolest Zone in Town",
        "organization"=>"Coolest Clinic in Town"
      ],
      "requestingClinician"=>"Coolest Doc in Town",
      "supportingInformation" => "ne’er-do-welllistic a.k.a lazyaz dude",
      "investigation" => $testType->name,
      "orderStage" => "op",//ip|op
      "labNo" => Str::random(),
    ];

    $testRequest = $cleint->request('POST', 'http://blis3.local/api/testrequest', [
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
