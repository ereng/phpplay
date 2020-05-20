<?php

namespace App\Console\Commands;

use DB;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class ML4AfrikaSingularMap extends Command
{
  protected $signature = 'ml4afrika:mapsingle';

  protected $description = 'Command description';

  public function __construct()
  {
      parent::__construct();
  }

  public function handle()
  {
    try {

      $mapTestTypeStore = $this->mapTestTypeStore(
        $client_id = 1,
        $test_type_id = 15,
        $emr_alias = 'RiDp2V9m4r3',
        $system = 'http://www.mhealth4afrika.eu/fhir/StructureDefinition/dataElementCode',
        $code = 'RiDp2V9m4r3',
        $display = 'Pregnancy Test'
      );

      $mapTestTypeStoreId = json_decode($mapTestTypeStore->getBody()->getContents())->id;

      $mapResultStore = $this->mapResultStore(
        $emr_test_type_alias_id = $mapTestTypeStoreId,
        'Positive',
        null
      );
      $mapResultStore = $this->mapResultStore(
        $emr_test_type_alias_id = $mapTestTypeStoreId,
        'Negative',
        null
      );
      $mapResultStore = $this->mapResultStore(
        $emr_test_type_alias_id = $mapTestTypeStoreId,
        'Indeterminate',
        null
      );
    } catch (\GuzzleHttp\Exception\ClientException $e) {

      // status 401
      echo "Token Expired\n";
      $clientLogin = new Client();
      // send results for individual tests for starters
      $loginResponse = $clientLogin->request('POST', env('BLIS_LOGIN_URL', 'http://192.168.134.53/api/tpa/login'), [
        'headers' => [
          'Accept' => 'application/json',
          'Content-type' => 'application/json'
        ],
        'json' => [
          // 'email' => 'admin',//test server
          // 'password' => 'district'//test server
          'email' => 'ml4afrika@emr.dev',
          'password' => 'password'
        ],
      ]);

      if ($loginResponse->getStatusCode() == 200) {
        $accessToken = json_decode($loginResponse->getBody()->getContents())->access_token;
        \App\ThirdPartyApp::where('email','ml4afrika@play.dev')->update(['access_token' => $accessToken]);
      }else{
        dd('real problem up in here');
      }
    }
  }

  public function mapTestTypeStore($client_id,$test_type_id,$emr_alias,$system,$code,$display)
  {
    $accessToken = \App\ThirdPartyApp::where('email','ml4afrika@play.dev')->first()->access_token;

    $client = new Client();
    $data =[
      "client_id" => $client_id,
      "test_type_id" => $test_type_id,
      "emr_alias" => $emr_alias,
      "system" => $system,
      "code" => $code,
      "display" => $display,
    ];

    $response = $client->request('POST', env('BLIS_MAP_TESTTYPE_STORE_URL', 'http://192.168.134.53/api/maptesttypestore'), [
      'headers' => [
        'Accept' => 'application/json',
        'Content-type' => 'application/json',
        'Authorization' => 'Bearer '.$accessToken,
      ],
      'json' => $data,
    ]);
    return $response;
  }


  public function mapResultStore($emr_test_type_alias_id,$result,$blis_alias)
  {

    $accessToken = \App\ThirdPartyApp::where('email','ml4afrika@play.dev')->first()->access_token;

    $client = new Client();

    $data =[
      "emr_test_type_alias_id" => $emr_test_type_alias_id,
      "emr_alias" => $result,
      "measure_range_name" => $blis_alias,
    ];

    $response = $client->request('POST', env('BLIS_MAP_RESULT_STORE_URL', 'http://192.168.134.53/api/mapresultstore'), [
      'headers' => [
        'Accept' => 'application/json',
        'Content-type' => 'application/json',
        'Authorization' => 'Bearer '.$accessToken,
      ],
      'json' => $data,
    ]);
    return $response;
  }


}
