<?php

namespace App\Console\Commands;

use DB;
use GuzzleHttp\Client;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use GuzzleHttp\Exception\ClientException;

class ML4AfrikaDemoReport extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'ml4afrika:report';

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
      $testRequest = $this->sendTestResults();
    } catch (\GuzzleHttp\Exception\ClientException $e) {
      echo "getting token\n";
      $this->getToken();
    }
  }


  public function sendTestResults()
  {
    $accessToken = \App\ThirdPartyApp::where('email','ml4afrika@play.dev')->first()->access_token;

    $results = [
   "resourceType" => "DiagnosticReport",
   "contained" => [
      [
         "resourceType" => "Observation",
         "id" => "observation159",
         "extension" => [
            [
               "url" => "http://www.mhealth4afrika.eu/fhir/StructureDefinition/dataElementCode",
               "valueCode" => "preg_test_results"
            ]
         ],
         "status" => "final",
         "code" => [
            "coding" => [
               [
                  "system" => "http://www.mhealth4afrika.eu/fhir/StructureDefinition/dataElementCode",
                  "code" => "preg_test_results",
                  "display" => "Pregnancy Test"
               ]
            ]
         ],
         "effectiveDateTime" => "2019-05-08T16:34:23+03:00",
         "performer" => [
            [
               "reference" => "Practitioner/admin@blis.local"
            ]
         ],
         "valueString" => "Positive"
      ]
   ],
   "extension" => [
      [
         "url" => "http://www.mhealth4afrika.eu/fhir/StructureDefinition/eventId",
         "valueString" => "twOZOkgfP7a"
      ]
   ],
   "identifier" => [
      [
         "value" => "90"
      ]
   ],
   "subject" => [
      "reference" => "Patient/N0N6ZCXa7eT"
   ],
   "context" => [
      "reference" => "Encounter/twOZOkgfP7a"
   ],
   "status" => "final",
   "code" => [
      "coding" => [
         [
            "system" => "http://www.mhealth4afrika.eu/fhir/StructureDefinition/diagnosticReportCode",
            "code" => "blis-lab"
         ]
      ]
   ],
   "performer" => [
      [
         "actor" => [
            "reference" => "Practitioner/admin@blis.local"
         ]
      ]
   ],
   "result" => [
      [
         "reference" => "#observation159"
      ]
   ]
];

    $client = new Client();

    // use verb to decide
    try {
      // send results for individual tests
      $response = $client->request('POST', 'http://192.168.134.53:8080/servicefhir/api/blis', [
        'headers' => [
          'Accept' => 'application/json',
          'Content-type' => 'application/json',
          'Authorization' => 'Bearer '.$accessToken
        ],
        'json' => $results
      ]);
        \Log::info($response->getStatusCode());
      if ($response->getStatusCode() == 200) {
        \Log::info('results successfully sent to emr');
      }elseif ($response->getStatusCode() == 204) {
        \Log::info('204:The server successfully processed the request, but is not returning any content.');
      }
    } catch (\GuzzleHttp\Exception\ClientException $e) {
    \Log::info($e->getMessage());
    }
  }

  public function getToken()
  {
    $clientLogin = new Client();

    $authenticationPayload  = [
      'headers' => [
        'Authorization' => 'Basic '.base64_encode('ilab:87047e052-e35a-91e4-eaa4-43be9615eb8'),
        'Accept' => 'application/json',
        'Content-type' => 'application/x-www-form-urlencoded',
      ],
      'form_params' => [
        'username' => 'ClinicManager',
        'password' => 'CM@n@ger2019',
        'grant_type' => 'password',
      ],
    ];

    $loginResponse = $clientLogin->request('POST', 'http://192.168.134.53:8080/mhealth4afrika/uaa/oauth/token', $authenticationPayload);

   if ($loginResponse->getStatusCode() == 200) {

    $accessToken = json_decode($loginResponse->getBody()->getContents())->access_token;

    \App\ThirdPartyApp::where('email','ml4afrika@play.dev')->update(['access_token' => $accessToken]);

    $this->sendTestResults();
    }
  }
}





