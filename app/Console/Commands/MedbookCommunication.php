<?php

namespace App\Console\Commands;

use DB;
use Uuid;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class MedbookCommunication extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'medbook:conveyance';

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
      $loginResponse = $clientLogin->request('POST', env('BLIS_LOGIN_URL', 'http://blis.test/api/tpa/login'), [
        'headers' => [
          'Accept' => 'application/json',
          'Content-type' => 'application/json'
        ],
        'json' => [
          'email' => 'default@emr.dev',
          'password' => 'password'
        ],
      ]);

      if ($loginResponse->getStatusCode() == 200) {

        $accessToken = json_decode($loginResponse->getBody()->getContents())->access_token;
        \App\ThirdPartyApp::where('email','medbook@play.dev')->update(['access_token' => $accessToken]);

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
    $accessToken = \App\ThirdPartyApp::where('email','medbook@play.dev')->first()->access_token;

    $testType = DB::connection('mysqlblis')->table('test_types')->inRandomOrder()->first();

    $cleint = new Client();

    $data =[
    "resourceType"=> "ProcedureRequest",
    "contained"=> [
      [
        "resourceType"=> "Patient",
        "id"=> "patient1",
        "identifier"=> [
          [
            "value"=> "DFLT".Str::random(),
          ]
        ],
        "name"=> [
          [
            "family"=> "Ogwok",
            "given"=> [
              "Grace"
            ]
          ]
        ],
        "gender"=> "female",
        "birthDate"=> "1990-05-30"
      ]
    ],
    "extension"=> [
      [
        "url"=> "http://www.mhealth4afrika.eu/fhir/StructureDefinition/eventId",
        "valueString"=> "exampleEventId"
      ]
    ],
    "code"=> [
      "coding"=> [
        [
          "system"=> "http://www.mhealth4afrika.eu/fhir/StructureDefinition/dataElementCode",
          "code"=> "hbCodeExample",
          "display"=> "Hemoglobin [Mass/volume] in Blood"
        ]
      ]
    ],
    "subject"=> [
        "reference"=> "#patient1"
    ],
      "item" => [
        [
          // revise this bad boy from the reff
          "test_type_id"=>$testType->id,
          "specimen" => "code"
        ]
      ],
      "requester"=> [
        "agent"=> [
          "reference"=> "Practitioner/examplePractitionerId",
          "name"=>"Coolest Doc in Town",
          "contact"=>"+777 7777 777 777",
          "organization"=>"Coolest Clinic in Town"
        ]
      ]
    ];

    $testRequest = $cleint->request('POST', 'http://blis.test/api/testrequest', [
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
