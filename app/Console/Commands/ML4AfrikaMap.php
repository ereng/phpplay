<?php

namespace App\Console\Commands;

use DB;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class ML4AfrikaMap extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */

             /** action(s) **\
              |    seed     |
              | getmappings |
              | getesttypes |
              |    store    |
              |   destroy   |
             \**            **/         
  protected $signature = 'ml4afrika:map {action}';

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
    if ($this->argument('action') == 'store') {
      try {
        $testTypes = DB::connection('mysqlml4afrika')->table('test_types')->get();
        foreach ($testTypes as $testType) {
            $testType = DB::connection('mysqlml4afrika')->table('test_types')
                ->where('blis_alias',$testType->blis_alias)->first();
                echo $testType->blis_alias."\n";
          $mapTestTypeStore = $this->mapTestTypeStore(
            $client_id = 1,
            $test_type_id = $testType->id,
            $emr_alias = $testType->data_element_id,
            $system = 'http://www.mhealth4afrika.eu/fhir/StructureDefinition/dataElementCode',
            $code = $testType->data_element_id,
            $display = $testType->name
          );

          $results = DB::connection('mysqlml4afrika')->table('results')
            ->where('test_type_id',$testType->id)->get();

          $mapTestTypeStoreId = json_decode($mapTestTypeStore->getBody()->getContents())->id;
          foreach ($results as $result) {
            echo $result->result."\n";
            $mapResultStore = $this->mapResultStore(
              $emr_test_type_alias_id = $mapTestTypeStoreId,
              $result->result,
              null
            );
          }
        }
      } catch (\GuzzleHttp\Exception\ClientException $e) {

        // status 401
        echo "Token Expired\n";
        $clientLogin = new Client();
        // send results for individual tests for starters
        $loginResponse = $clientLogin->request('POST', env('BLIS_LOGIN_URL',
          'http://blis3.local/api/tpa/login'), [
          'headers' => [
            'Accept' => 'application/json',
            'Content-type' => 'application/json'
          ],
          'json' => [
            'email' => 'system@his.prod',
            'password' => 'password'
          ],
        ]);

        if ($loginResponse->getStatusCode() == 200) {
          $accessToken = json_decode($loginResponse->getBody()->getContents())
            ->access_token;
echo "gotten token\n";
echo $accessToken."\n";
          \App\ThirdPartyApp::where('email','system@his.prod')
            ->update(['access_token' => $accessToken]);
\Log::info(\App\ThirdPartyApp::where('email','system@his.prod')->first());



// -------------------------
        $testTypes = DB::connection('mysqlml4afrika')->table('test_types')->get();
        foreach ($testTypes as $testType) {
            $testType = DB::connection('mysqlml4afrika')->table('test_types')
                ->where('blis_alias',$testType->blis_alias)->first();
                echo $testType->blis_alias."\n";
          $mapTestTypeStore = $this->mapTestTypeStore(
            $client_id = 1,
            $test_type_id = $testType->id,
            $emr_alias = $testType->data_element_id,
            $system = 'http://www.mhealth4afrika.eu/fhir/StructureDefinition/dataElementCode',
            $code = $testType->data_element_id,
            $display = $testType->name
          );

          $results = DB::connection('mysqlml4afrika')->table('results')
            ->where('test_type_id',$testType->id)->get();

          $mapTestTypeStoreId = json_decode($mapTestTypeStore->getBody()->getContents())->id;
          foreach ($results as $result) {
            echo $result->result."\n";
            $mapResultStore = $this->mapResultStore(
              $emr_test_type_alias_id = $mapTestTypeStoreId,
              $result->result,
              null
            );
          }
        }

// -------------------------



        }else{
          dd('real problem up in here');
        }
      }
    }elseif ($this->argument('action') == 'get') {
      # code...
    }
  }

  public function mapTestTypeStore(
    $client_id,
    $test_type_id,
    $emr_alias,
    $system,
    $code,
    $display){
    $accessToken = \App\ThirdPartyApp::where('email','system@his.prod')
      ->first()->access_token;
echo "mapping...\n";

// mapTestTypeStore

echo $accessToken."\n";
    $client = new Client();
echo "new client...\n";
    $data =[
      "client_id" => $client_id,
      "test_type_id" => $test_type_id,
      "emr_alias" => $emr_alias,
      "system" => $system,
      "code" => $code,
      "display" => $display,
    ];
echo "data put together...\n";

    $response = $client->request('POST',
      'http://blis3.local/api/maptesttypestore', [
      'headers' => [
        'Accept' => 'application/json',
        'Content-type' => 'application/json',
        'Authorization' => 'Bearer '.$accessToken,
      ],
      'json' => $data,
    ]);
echo "submitted\n";
\Log::info($response);
    return $response;
  }


  public function mapResultStore(
    $emr_test_type_alias_id,
    $result,
    $blis_alias){

    $accessToken = \App\ThirdPartyApp::where('email','system@his.prod')
      ->first()->access_token;

    $client = new Client();

    $data = [
      "emr_test_type_alias_id" => $emr_test_type_alias_id,
      "emr_alias" => $result,
      "measure_range_name" => $blis_alias,
    ];

    $response = $client->request('POST', env('BLIS_MAP_RESULT_STORE_URL',
      'http://blis3.local/api/mapresultstore'), [
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
