<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use App\Models\Pluralizer;
use DB;

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

class MasterGen extends Command
{
    protected $signature = 'gen {primary_table} {folder} {secondary_tables*}';

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
// dd($primaryTable);
      \Eloquent::unguard();

      $connection = env('GENERATION_CONNECTION');
      $viewFolder = $this->argument('folder');
      $basePath = env('BASE_PATH');
      $modelFrontEnd = '';
      $importModelFrontEnd = [];
      $fieldsFrontEnd = [];
      $viewRoutes = '';
      $pivotFields = $this->getFields($connection,$primaryTable);

// $primaryTable
// $secondaryTables
      $withSecondary = '';
      $modelRelationSecondary = '';
      $importModelSecondary = '';

      if (DB::connection($connection)->select('show columns from ' . $primaryTable)[0]->Field == 'id') {
        $modelPrimary = $this->getModelName($primaryTable);
        $modelFrontEnd = $modelPrimary;
        $modelRelationPrimary='
    public function '.lcfirst($modelPrimary).'()
    {
        return $this->hasMany(\'App\\'.$modelPrimary.'\');
    }
';

        $withPrimary = "'".lcfirst($modelPrimary)."'";
        $importModelPrimary ="use App\\".$modelPrimary.";\n";

        foreach ($secondaryTables as $secondaryTable) {
          $modelSecondary = $this->getModelName(explode("=", $secondaryTable)[1]);

          $importModelSecondary .="use App\\".$modelSecondary.";\n";
          $importModelFrontEnd[] = lcfirst($modelSecondary);


          if ($withSecondary != '') {
            $withSecondary.=",'".lcfirst($modelSecondary)."'";
          }else{
            $withSecondary.="'".lcfirst($modelSecondary)."'";
          }

          $modelRelationSecondary.='

            public function '.lcfirst($modelSecondary).'()
            {
                return $this->belongsTo(\'App\\'.$modelSecondary.'\');
            }
        ';
          \App\Console\Commands\MVC\Model::get($connection,explode("=", $secondaryTable)[1],$modelRelationPrimary,$basePath);
          $fieldsSecondary = $this->getFields($connection,explode("=", $secondaryTable)[1]);
          \App\Console\Commands\MVC\Controller::get($fieldsSecondary,$modelSecondary,$importModelPrimary,$withPrimary,$basePath);

        }
        $fieldsPrimary = $this->getFields($connection,$primaryTable);
        $fieldsFrontEnd = $fieldsPrimary;
        \App\Console\Commands\MVC\Model::get($connection,$primaryTable,$modelRelationSecondary,$basePath);
        \App\Console\Commands\MVC\Controller::get($fieldsPrimary,$modelPrimary,$importModelSecondary,$withSecondary,$basePath);

      }else{
        $modelSecondary1 = $this->getModelName(explode("=", $secondaryTables[0])[1]);
        $modelSecondary2 = $this->getModelName(explode("=", $secondaryTables[1])[1]);

        $modelFrontEnd = $modelSecondary1;

        $importModelSecondary1 ="use App\\".$modelSecondary1.";\n";
        $importModelSecondary2 ="use App\\".$modelSecondary2.";\n";

        $importModelFrontEnd = [lcfirst($modelSecondary1),lcfirst($modelSecondary2),];

        $withSecondary1="'".lcfirst($modelSecondary1)."'";
        $withSecondary2="'".lcfirst($modelSecondary2)."'";

        $modelRelationSecondary1='

    public function '.lcfirst($modelSecondary1).'()
    {
        return $this->belongsToMany(\'App\\'.$modelSecondary1.'\');
    }
';

        $modelRelationSecondary2='

    public function '.lcfirst($modelSecondary2).'()
    {
        return $this->belongsToMany(\'App\\'.$modelSecondary2.'\');
    }
';

        \App\Console\Commands\MVC\Model::get($connection,explode("=", $secondaryTables[0])[1],$modelRelationSecondary2,$basePath);
        \App\Console\Commands\MVC\Model::get($connection,explode("=", $secondaryTables[1])[1],$modelRelationSecondary1,$basePath);

        $fieldsSecondary1 = $this->getFields($connection,explode("=", $secondaryTables[0])[1]);
        $fieldsSecondary2 = $this->getFields($connection,explode("=", $secondaryTables[1])[1]);

        $fieldsFrontEnd = $fieldsSecondary1;
        $attachmentDetachment = '
    public function attach()
    {
      $'.lcfirst($modelSecondary1).' = '.$modelSecondary1.'::find(request(\''.lcfirst($modelSecondary1).'_id\'));
      try{
        $'.lcfirst($modelSecondary1).'->'.lcfirst($modelSecondary2).'s()->attach(request(\''.lcfirst($modelSecondary1).'_id\'));
        return redirect()->action(\''.$modelSecondary1.'Controller@show\',[\''.lcfirst($modelSecondary1).'_id\' => request(\''.lcfirst($modelSecondary1).'_id\')]);
      } catch (\Illuminate\Database\QueryException $e) {
        return response()->json([\'status\' => \'error\', \'message\' => $e->getMessage()]);
      }
    }

    public function detach(){
      $'.lcfirst($modelSecondary1).' = '.$modelSecondary1.'::find(request(\''.lcfirst($modelSecondary1).'_id\'));
      try{
        $'.lcfirst($modelSecondary1).'->'.lcfirst($modelSecondary2).'s()->detach(request(\''.lcfirst($modelSecondary1).'_id\'));
        return redirect()->action(\''.$modelSecondary1.'Controller@show\',[\''.lcfirst($modelSecondary1).'_id\' => request(\''.lcfirst($modelSecondary1).'_id\')]);
      } catch (\Illuminate\Database\QueryException $e) {
        return response()->json([\'status\' => \'error\', \'message\' => $e->getMessage()]);
      }
    }
';

        $attachmentDetachmentAPIRoutes = '
    Route::get(\''.strtolower($modelSecondary1).'/'.strtolower($modelSecondary2).'/attach\', \''.$modelSecondary1.'Controller@attach\');
    Route::get(\''.strtolower($modelSecondary1).'/'.strtolower($modelSecondary2).'/detach\', \''.$modelSecondary1.'Controller@detach\');
';

        $viewRoutes .= '
\'/api/'.strtolower($modelSecondary1) .'/'.strtolower($modelSecondary2) .'/attach?'.lcfirst($modelSecondary1).'_id=\'+'.lcfirst($modelSecondary1).'_id+\'&'.lcfirst($modelSecondary2).'_id=\'+'.lcfirst($modelSecondary2).'_id
\'/api/'.strtolower($modelSecondary1) .'/'.strtolower($modelSecondary2) .'/detach?'.lcfirst($modelSecondary1).'_id=\'+'.lcfirst($modelSecondary1).'_id+\'&'.lcfirst($modelSecondary2).'_id=\'+'.lcfirst($modelSecondary2).'_id
';

        $apiRouteFile = fopen($basePath."/routes/api.php", "a") or die("Unable to open file!");
        fwrite($apiRouteFile, $attachmentDetachmentAPIRoutes);
        fclose($apiRouteFile);

        $attachmentDetachmentFrontEndRoutes = '';

        \App\Console\Commands\MVC\Controller::get($fieldsSecondary1,$modelSecondary1,$importModelSecondary2,$withSecondary2,$basePath,$attachmentDetachment);
        \App\Console\Commands\MVC\Controller::get($fieldsSecondary2,$modelSecondary2,$importModelSecondary1,$withSecondary1,$basePath);
      }

// todo: craft routes for the attach and detach whenever there is such a thing to be written at the end of the relevant files
      if (env('FRONTEND_TYPE') == 'external') {
\Log::info('hitting front');
\Log::info(env('FRONTEND_PATH'));
        $viewPath = env('FRONTEND_PATH').'/src/components/'.$viewFolder;
        $viewRoutePath = '/var/www/erengplay/storage/logs/router.js';
        $viewRoutes .= '
import '.$modelFrontEnd.' from \'./components/'.$viewFolder.'/index.vue\'
    {
      path: \'/'.strtolower($modelFrontEnd).'\',
      name: \''.$modelFrontEnd.'\',
      component: '.$modelFrontEnd.',
      beforeEnter: ifAuthenticated,
    },
';

      }else{
\Log::info('hitting back');
        $viewPath = $basePath.'/resources/assets/js/components/'.$viewFolder;
        $viewRoutePath = $basePath.'/resources/assets/js/router/index.js';
        $viewRoutes .= '
import '.$modelFrontEnd.' from \'./components/'.$viewFolder.'/index.vue\'
    {
      path: \'/'.strtolower($modelFrontEnd).'\',
      name: \''.$modelFrontEnd.'\',
      component: '.$modelFrontEnd.',
      beforeEnter: ifAuthenticated,
    },
';
      }


      \App\Console\Commands\MVC\View::get($connection,$fieldsFrontEnd,$modelFrontEnd,$importModelFrontEnd,$viewPath);
      // \App\Console\Commands\MVC\View::get($connection,$pivotFields,$modelFrontEnd,$importModelFrontEnd,'/var/www/erengplay/storage/logs');
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
