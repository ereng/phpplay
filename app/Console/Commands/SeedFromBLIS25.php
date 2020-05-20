<?php

namespace App\Console\Commands;

use DB;
use Uuid;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class SeedFromBLIS25 extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'seed:blis25';
  // php artisan seed:blis25

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
    $bLIS25TestTypes = DB::connection('mysqlblis25')->table('test_types')->get();
    foreach ($bLIS25TestTypes as $bLIS25TestType) {

      // if its not in the db save it
      if (DB::connection('mysqlblis')->table('test_types')->where('name',$bLIS25TestType->name)->count() == 0) {

        $testTypeId = DB::connection('mysqlblis')->table('test_types')->insertGetId([
          'test_type_category_id' => 2,
          'name' => $bLIS25TestType->name,
        ]);

        DB::connection('mysqlblis')->table('measures')->insert([
          'measure_type_id' => 4,//MeasureType::free_text
          'test_type_id' => $testTypeId,
          'name' => $bLIS25TestType->name,
          'unit' => '',
        ]);
        // absolutely incorrect arragangment 
        DB::connection('mysqlblis')->table('test_type_mappings')->insert(
            ['test_type_id' => $testTypeId, 'specimen_type_id' => 1]);
      }
      echo "new_".$bLIS25TestType->name;
      echo "\n";
    }
  }
}
