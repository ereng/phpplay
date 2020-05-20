<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use DB;
use App\Models\Pluralizer;


class MasterNonPivotGen extends Command
{

/*
protected $signature = 'gen {connection} {table1} {folder?} {table2?} {table3?}';

php artisan set:env GENERATION_CONNECTION "mysqlschmgtsys"
php artisan set:env FRONTEND_TYPE "external"
php artisan set:env FRONTEND_PATH "/var/www/schmgtsysfront"
php artisan set:env VIEW_FOLDER "subject"
php artisan set:env BASE_PATH "/var/www/schmgtsys"
php artisan set:env LIST_FROM "index"
php artisan set:env DELETE_BY "delete"
php artisan set:env STORE_BY "store"
php artisan set:env UPDATE "yes"
php artisan set:env PAGINATE "yes"

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


php artisan gen {primary_table} {secondary_tables*} {folder}


php artisan gen class_subject class secondary_tables=classes secondary_tables=subjects
php artisan gen parent_student parent secondary_tables=parents secondary_tables=students
php artisan gen paper_subject subject secondary_tables=subjects secondary_tables=papers

php artisan gen student_subject student secondary_tables=students secondary_tables=subjects
php artisan gen combination_student student secondary_tables=students secondary_tables=combinations
php artisan gen class_stream class secondary_tables=classes secondary_tables=streams
php artisan gen assessment_student student secondary_tables=students secondary_tables=assessments
php artisan gen assessment_class assessment secondary_tables=assessments secondary_tables=classes
php artisan gen assessment_subject assessment secondary_tables=assessments secondary_tables=subjects


cd /var/www/erengplay && php artisan gen admission_encounter secondary_tables=admissions secondary_tables=encounters && cd /var/www/billing && git checkout routes/api.php && git diff


*/

  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'genx {primary_table} {folder} {secondary_tables*}';

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
    $viewFolder = $this->argument('folder');
    $connection = env('GENERATION_CONNECTION');
    $basePath = env('BASE_PATH');
    $modelFrontEnd = '';
    $importModelFrontEnd = [];
    $fieldsFrontEnd = [];
    $viewRoutes = '';
    $modelSecondaries = [];
    $viewPath = env('FRONTEND_PATH').'/src/components/'.$viewFolder;
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

        \App\Console\Commands\MVC\View::get(
          $connection,
          $fieldsFrontEnd,
          $modelFrontEnd,
          $importModelFrontEnd,
          $viewPath);
// TODO: firgure out rouytes
/*
  \'/api/'.strtolower($modelSecondary1) .'/'.strtolower($modelSecondary2) .'/attach?'.lcfirst($modelSecondary1).'_id=\'+'.lcfirst($modelSecondary1).'_id+\'&'.lcfirst($modelSecondary2).'_id=\'+'.lcfirst($modelSecondary2).'_id
  ';
*/
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

