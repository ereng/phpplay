<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use DB;
use App\Models\Pluralizer;


class MasterGenDialog extends Command
{

/*
protected $signature = 'gendialog {connection} {table1} {folder?} {table2?} {table3?}';


LIST_FROM eagerload|index
DELETE_BY detach|delete
STORE_BY attach|store
UPDATE yes|no
PAGINATE yes|no

paper_subject
assessment_class
assessment_subject
combination_student
paper_subject
student_subject
subject_teacher


php artisan gendialog {primary_table} {secondary_tables*} {folder}


php artisan gendialog class_subject class secondary_tables=classes secondary_tables=subjects
php artisan gendialog parent_student parent secondary_tables=parents secondary_tables=students
php artisan gendialog paper_subject subject secondary_tables=subjects secondary_tables=papers

php artisan gendialog student_subject student secondary_tables=students secondary_tables=subjects
php artisan gendialog combination_student student secondary_tables=students secondary_tables=combinations
php artisan gendialog class_stream class secondary_tables=classes secondary_tables=streams
php artisan gendialog assessment_student student secondary_tables=students secondary_tables=assessments
php artisan gendialog assessment_class assessment secondary_tables=assessments secondary_tables=classes
php artisan gendialog assessment_subject assessment secondary_tables=assessments secondary_tables=subjects


cd /var/www/erengplay && php artisan gendialog admission_encounter secondary_tables=admissions secondary_tables=encounters && cd /var/www/billing && git checkout routes/api.php && git diff


cd /var/www/erengplay && php artisan gendialog mysqlhis patient diagnoses secondary_tables=encounters secondary_tables=conditions && subl /var/www/erengplay/storage/logs/dialog.vue

*/

  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'gendialog {connection} {parent_model} {primary_table} {secondary_tables*}';

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
    $primaryTable = $this->argument('primary_table');
    $secondaryTables = $this->argument('secondary_tables');
    // $viewFolder = $this->argument('folder');
    $connection = $this->argument('connection');
    $basePath = env('BASE_PATH');
    $modelFrontEnd = '';
    $parentModel = $this->argument('parent_model');
    $importModelFrontEnd = [];
    $fieldsFrontEnd = [];
    $viewRoutes = '';
    $modelSecondaries = [];
    // $viewPath = env('FRONTEND_PATH').'/src/components/'.$viewFolder;
    $viewRoutePath = '/var/www/erengplay/storage/logs/router.js';

    \Eloquent::unguard();

    $withSecondary = '';
    $modelRelationSecondary = false;
    $importModelSecondary = '';
// dd($primaryTable);
// dd(DB::connection($connection)->select('show columns from ' . $primaryTable));
// dd((DB::connection($connection)->select('show columns from ' . $primaryTable)[0]->Field));


    // if (DB::connection($connection)->select('show columns from ' . $primaryTable)[0]->Field == 'id') {
      $modelPrimary = $this->getModelName($primaryTable);
      $modelFrontEnd = $modelPrimary;
// dd($modelPrimary);
      $withPrimary = "'".lcfirst($modelPrimary)."'";
      $importModelPrimary ="use App\\".$modelPrimary.";\n";

      foreach ($secondaryTables as $secondaryTable) {
        $modelSecondary = $this->getModelName(explode("=", $secondaryTable)[1]);
        $modelSecondaries[] = $modelSecondary;

        $importModelSecondary .="use App\\".$modelSecondary.";\n";
        $importModelFrontEnd[] = lcfirst($modelSecondary);


        if ($withSecondary != '') {
          $withSecondary.=",'".lcfirst($modelSecondary)."'";
        }else{
          $withSecondary.="'".lcfirst($modelSecondary)."'";
        }

        \App\Console\Commands\MVC\Model::get(
          $connection,
          explode("=", $secondaryTable)[1],
          $modelRelationPrimary=true,
          $basePath,
          $modelSecondaries);

        $fieldsSecondary = $this->getFields(
          $connection,
          explode("=", $secondaryTable)[1]);
      }

      $fieldsPrimary = $this->getFields($connection,$primaryTable);
      $fieldsFrontEnd = $fieldsPrimary;
      \App\Console\Commands\MVC\Model::get(
        $connection,
        $primaryTable,
        $modelRelationSecondary,
        $basePath,
        $modelSecondaries);

      \App\Console\Commands\MVC\Controller::get(
        $fieldsPrimary,
        $modelPrimary,
        $importModelSecondary,
        $withSecondary,
        $basePath,
        $attachmentDetachment=false);

        \App\Console\Commands\MVC\ViewDialog::get(
          $connection,
          $fieldsFrontEnd,
          $modelFrontEnd,
          $importModelFrontEnd,
          $parentModel
        );
// TODO: firgure out routes
/*
  \'/api/'.strtolower($modelSecondary1) .'/'.strtolower($modelSecondary2) .'/attach?'.lcfirst($modelSecondary1).'_id=\'+'.lcfirst($modelSecondary1).'_id+\'&'.lcfirst($modelSecondary2).'_id=\'+'.lcfirst($modelSecondary2).'_id
  ';
        $viewRoutes .= '
  import '.$modelFrontEnd.' from \'./components/'.$viewFolder.'/index.vue\'
      {
        path: \'/'.strtolower($modelFrontEnd).'\',
        name: \''.$modelFrontEnd.'\',
        component: '.$modelFrontEnd.',
        beforeEnter: ifAuthenticated,
      },
  ';

    $this->generateViewRoutes($viewRoutePath,$viewRoutes);
*/

  }

  public function getFields($connection,$table){
    $fields = [];
    $columns = DB::connection($connection)->select('show columns from ' . $table);

    foreach ($columns as $column) {

      if($column->Field=="id" ||
        $column->Field=="created_at" ||
        $column->Field=="updated_at" ||
        $column->Field=="deleted_at"){
      }else {
        $fields[$column->Field] = [
          'table' => $table,
          'Field' => $column->Field,
          'Type' => $column->Type,
          'Null' => $column->Null,
          'Key' => $column->Key,
          'Default' => $column->Default,
          'Extra' => $column->Extra,
        ];
      }
    }
    return $fields;
  }

  public function generateViewRoutes($path,$content){
      $myfile = fopen($path, "a") or die("Unable to open file!");
      fwrite($myfile, $content);
      fclose($myfile);
  }

  public function getModelName($table){
    $model = Pluralizer::singular(ucwords(preg_replace_callback('/_([a-z]?)/', function($match) {
      return strtoupper($match[1]);
    }, $table)));
    return $model;
  }
}

