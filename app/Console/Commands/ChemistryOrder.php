<?php

namespace App\Console\Commands;

use DB;
use Uuid;
use GuzzleHttp\Client;
// use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class ChemistryOrder extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'chemistry:order';

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
      $testType = DB::connection('mysqlblis')->table('test_types')
        ->where('name','something')
        ->orWhere('name','something')
        ->orWhere('name','something')
        ->orWhere('name','something')
        ->inRandomOrder()->first();
*/

      $cleint = new Client();

      $worksheet = [
        [
          "patient" => [
            "sequence"=>"1",
            "identifier" => "2-FIDO",
            "first_name"=> "FIDO",
            "last_name"=> "PETR MENGO",
            "birthDate"=> "1994-05-30",
            "gender"=> "male"
          ],
          "orders" => [
            ["sequence"=>"1","test_tyepe"=>"CALA","isurgent"=>"False","nature"=>"Serum"],
            ["sequence"=>"2","test_tyepe"=>"GPT","isurgent"=>"False","nature"=>"Serum"],
            ["sequence"=>"3","test_tyepe"=>"UREA","isurgent"=>"False","nature"=>"Serum"],
            ["sequence"=>"4","test_tyepe"=>"BD-2","isurgent"=>"False","nature"=>"Serum"],
            ["sequence"=>"5","test_tyepe"=>"BT-2","isurgent"=>"False","nature"=>"Serum"],
            ["sequence"=>"6","test_tyepe"=>"CRE","isurgent"=>"False","nature"=>"Serum"],
          ]
        ],
        [
          "patient" => [
            "sequence"=>"1",
            "identifier" => "2-DIANA",
            "first_name"=> "DIANA",
            "last_name"=> "DILIBERTO KAMAU",
            "birthDate"=> "1994-05-30",
            "gender"=> "male"
          ],
          "orders" => [
            ["sequence"=>"1","test_tyepe"=>"CALA","isurgent"=>"False","nature"=>"Serum"],
            ["sequence"=>"2","test_tyepe"=>"GPT","isurgent"=>"False","nature"=>"Serum"],
            ["sequence"=>"3","test_tyepe"=>"UREA","isurgent"=>"False","nature"=>"Serum"],
            ["sequence"=>"4","test_tyepe"=>"BD-2","isurgent"=>"False","nature"=>"Serum"],
            ["sequence"=>"5","test_tyepe"=>"BT-2","isurgent"=>"False","nature"=>"Serum"],
            ["sequence"=>"6","test_tyepe"=>"CRE","isurgent"=>"False","nature"=>"Serum"],
          ]
        ],
        [
          "patient" => [
            "sequence"=>"1",
            "identifier" => "2-KIKI",
            "first_name"=> "KIKI",
            "last_name"=> "AKINYI GIORGIO",
            "birthDate"=> "1994-05-30",
            "gender"=> "male"
          ],
          "orders" => [
            ["sequence"=>"1","test_tyepe"=>"CALA","isurgent"=>"False","nature"=>"Serum"],
            ["sequence"=>"2","test_tyepe"=>"GPT","isurgent"=>"False","nature"=>"Serum"],
            ["sequence"=>"3","test_tyepe"=>"UREA","isurgent"=>"False","nature"=>"Serum"],
            ["sequence"=>"4","test_tyepe"=>"BD-2","isurgent"=>"False","nature"=>"Serum"],
            ["sequence"=>"5","test_tyepe"=>"BT-2","isurgent"=>"False","nature"=>"Serum"],
            ["sequence"=>"6","test_tyepe"=>"CRE","isurgent"=>"False","nature"=>"Serum"],
          ]
        ],
      ];

      $testRequest = $cleint->request('POST', 'http://localhost:5150', [
        'headers' => [
          'Accept' => 'application/json',
          'Content-type' => 'application/json',
        ],
        'json' => $worksheet,
      ]);

      return $testRequest;
  }

}
