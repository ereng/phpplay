<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use DB;

class SMSFieldGen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:fields';

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
      \Eloquent::unguard();
      $tables = [
        "assessment_categories",
        "religions",
        "nationalities",
        "combinations",
        "parents",
        "results",
        "classes",
        "streams",
        "students",
        "subject_teachers",
        "assessments",
        "subjects",
        "papers",
      ];


      $viewDirectory = [
        "assessment_categories" => '/configuration/',
        "religions" => '/configuration/',
        "nationalities" => '/configuration/',
        "combinations" => '/configuration/subject/',
        "parents" => '/student/',
        "results" => '/assessment/',
        "classes" => '/configuration/',
        "streams" => '/configuration/class/',
        "students" => '/',
        "subject_teachers" => '/configuration/',
        "assessments" => '/',
        "subjects" => '/configuration/',
        "papers" => '/configuration/subject/',
      ];


      $myfile = fopen("/var/www/schmgtsys/storage/logs/FieldsArray.php", "w") or die("Unable to open file!");
      $fields='
      $'.'views=[';

      foreach ($tables as $key => $table) {

          $tableSingular = str_singular($table);

            $options = [
              'create' => ['method' => 'POST', 'page' => 'create', 'route' => 'store', 'action' => 'Create',],
              'edit' => ['method' => 'PUT', 'page' => 'edit', 'route' => 'update', 'action' => 'Edit',],
              'index' => ['method' => '', 'page' => 'index', 'route' => 'index', 'action' => '',],
            ];

            foreach ($options as $key => $option) {


            $fields.="
        [
          'path' => '/var/www/schmgtsys/resources/views".$viewDirectory [$table].str_replace('_', '', $tableSingular)."/".$option['page'].".blade.php',
          'name' => '".str_replace('_', '', $tableSingular)."',
          'action' => '".$option['action']." ".ucwords(str_replace('_', ' ', $tableSingular))."',
          'breadcrumb' => \"\\n    <li><a href=\\\"{{URL::route('".str_replace('_', '', $tableSingular).".index')}}\\\">".ucwords(str_replace('_', ' ', $tableSingular))."</a></li>\\n    <li class=\\\"active\\\">".$option['action']." ".ucwords(str_replace('_', ' ', $tableSingular))."</li>\",
          'method' => '".$option['method']."',
          'route' => '/".str_replace('_', '', $tableSingular)."/".$option['route']."',
          'cancel-route' => '/".str_replace('_', '', $tableSingular)."',
          'page' => '/".str_replace('_', '', $tableSingular)."/".$option['page']."',
          'fields' => [
          ";

            // $tableFields = DB::table($table)->get();
            $tableFields = Schema::getColumnListing($table);

            foreach ($tableFields as $tableField) {

                if($tableField=="id" || $tableField=="created_at" || $tableField=="updated_at" || $tableField=="deleted_at"){

                }else{
                    // generate field
                $fields.="
            [
              'type'=>'text',
              'label'=>'".ucwords(str_replace('_', ' ', $tableField))."',
              'value'=>'".$tableField."',
              'init'=>'\'\'',
            ],";
                    

                }
            }

            $fields.="
          ],
        ],";

            }

      }
      $fields.='
      ];';

      fwrite($myfile, $fields);
      fclose($myfile);

    }
}
