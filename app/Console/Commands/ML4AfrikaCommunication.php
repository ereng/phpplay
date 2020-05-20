<?php

namespace App\Console\Commands;

use DB;
use GuzzleHttp\Client;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use GuzzleHttp\Exception\ClientException;

class ML4AfrikaCommunication extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'ml4afrika:conveyance';

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
      $loginResponse = $clientLogin->request('POST', env('BLIS_LOGIN_URL', 'http://blis3.local/api/tpa/login'), [
        'headers' => [
          'Accept' => 'application/json',
          'Content-type' => 'application/json'
        ],
        'json' => [
          'email' => 'ml4afrika@emr.dev',
          'password' => 'password'
        ],
      ]);

      if ($loginResponse->getStatusCode() == 200) {

        $accessToken = json_decode($loginResponse->getBody()->getContents())->access_token;
        \App\ThirdPartyApp::where('email','ml4afrika@play.dev')->update(['access_token' => $accessToken]);

        $testRequest = $this->testRequest();

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

  public function testRequest()
  {
    $accessToken = \App\ThirdPartyApp::where('email','ml4afrika@play.dev')->first()->access_token;

    $element = DB::connection('mysqlblis')->table('emr_test_type_aliases')->inRandomOrder()->first();
    $client = new Client();

    $faker = Faker::create();

    $data =[
      "resourceType"=> "ProcedureRequest",
      "contained"=> [
        [
          "resourceType"=> "Patient",
          "id"=> "patient1",
          "identifier"=> [
            [
              "value" => $faker->postcode,
            ]
          ],
          "name"=> [
            [
              "family"=> $faker->lastName,
              "given"=> [
                $faker->firstNameFemale,
              ]
            ]
          ],
          "gender"=> "female",
          "birthDate"=> "1990-05-30"
        ],
        [
          "resourceType" => "Practitioner",
          "id" => "practitioner",
          "identifier" => [
            [
              "value" => $faker->userName,
            ]
          ],
          "name" => [
            [
              "family" => $faker->lastName,
              "given" => [
                $faker->firstNameMale
              ]
            ]
          ],
          "telecom" => [
            [
              "system" => "phone",
              "value" => $faker->e164PhoneNumber
            ],
            [
              "system" => "email",
              "value" => $faker->freeEmail
            ],
          ]
        ]
      ],
      "code"=> [
        "coding"=> [
          [
            "system"=> "http://www.mhealth4afrika.eu/fhir/StructureDefinition/dataElementCode",
            "code"=> $element->emr_alias,
            "display"=> "Some Test Name"
          ]
        ]
      ],
      "extension"=> [
        [
          "url"=> "http://www.mhealth4afrika.eu/fhir/StructureDefinition/eventId",
          "valueString"=> $faker->swiftBicNumber
        ]
      ],
      "subject"=> [
        "reference"=> "#patient1"
      ],
      "context" => [
        "reference" => "Encounter/".$faker->swiftBicNumber."/eventID"
      ],
      "requester"=> [
        "agent"=> [
          "reference"=> "#practitioner",
        ]
      ]
    ];

    $testRequest = $client->request('POST', env('BLIS_TEST_REQUEST_URL', 'http://blis3.local/api/testrequest'), [
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
