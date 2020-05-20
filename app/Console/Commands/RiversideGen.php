<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use DB;
use App\Models\Pluralizer;


class RiversideGen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'riverside:gen';

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
        $tables = DB::connection('mysqlriverside')->select('show tables');

        //Clear the routes file api.php
        /*
        $myfile = fopen("api.php", "a") or die("Unable to open file!");
        ftruncate($myfile, 0);
        fclose($myfile);
        */
        $skipModels = [
            'migrations',
            'oauth_auth_codes',
            'oauth_access_tokens',
            'oauth_refresh_tokens',
            'oauth_clients',
            'oauth_personal_access_clients',
            'password_resets',
            'users',
            'roles',
            'role_user',
            'permissions',
            'permission_role',
            'third_party_apps',

            'messages',
            'ticket_statuses',
            'media',
            'telescope_entries',
            'telescope_entries_tags',
            'telescope_monitoring',
            'cup_group_user',
            'cup_groups',
        ];


        $skipControllers = [
            'migrations',
            'oauth_auth_codes',
            'oauth_access_tokens',
            'oauth_refresh_tokens',
            'oauth_clients',
            'oauth_personal_access_clients',
            'password_resets',
            'users',
            'roles',
            'role_user',
            'permissions',
            'permission_role',
            'third_party_apps',

            'messages',
            'ticket_statuses',
            'media',
            'telescope_entries',
            'telescope_entries_tags',
            'telescope_monitoring',
            'tickets',
            'articles',
            'cup_group_user',
        ];

        $skipVue = [
            'migrations',
            'oauth_auth_codes',
            'oauth_access_tokens',
            'oauth_refresh_tokens',
            'oauth_clients',
            'oauth_personal_access_clients',
            'password_resets',
            'users',
            'roles',
            'role_user',
            'permissions',
            'permission_role',
            'third_party_apps',

            'messages',
            'ticket_statuses',
            'media',
            'telescope_entries',
            'telescope_entries_tags',
            'telescope_monitoring',
            'activities',
            'tickets',
            'articles',

// may have to remove them also from controller
            'predictions',
            'game_team',
            'points',
            'cup_group_tournament',
            'cup_group_user',

        ];

        $tableAssociations = [
          ['parentTable' => 'cup_group_user' ,'childTable' => 'cup_groups']
        ];
        foreach ($tables as $table) {
            if (!in_array($table->Tables_in_schmgtsys, $skipModels)) {
                $this->generateModel($table->Tables_in_schmgtsys);
            }

            if (!in_array($table->Tables_in_schmgtsys, $skipControllers)) {
                $this->generateController($table->Tables_in_schmgtsys);
            }

            if (!in_array($table->Tables_in_schmgtsys, $skipVue)) {
                $this->generateVue($table->Tables_in_schmgtsys);
            }
        }

        foreach ($tableAssociations as $tableAssociation) {

          $this->generateRelatedVue($tableAssociation['parentTable'],$tableAssociation['childTable']);
        }
    }

    public function generateController($table){
        //headers
        $controller='<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;';


        $fields = DB::connection('mysqlriverside')->select('show columns from ' . $table);

        $modelName = Pluralizer::singular(ucwords(preg_replace_callback('/_([a-z]?)/', function($match) {
                return strtoupper($match[1]);
            }, $table)));
        $controller.="
use App\Models\\".$modelName.";\n";

        // eagar loader with
        $with = '';
        
        foreach ($fields as $field) {
          //Generate validation rules
          if($field->Type=="int(10) unsigned" && substr($field->Field, -3) == '_id'){

            $stringLength = strlen($field->Field)-3;

            // make a model name and import those models
            $importModelName = str_replace(' ', '', ucwords(str_replace('_', ' ', substr($field->Field,0, $stringLength))));

            $controller.="use App\Models\\".$importModelName.";\n";
            // building the eager loader
            if ($with != '') {
              $with.=",'".lcfirst($importModelName)."'";
            }else{
              $with.="'".lcfirst($importModelName)."'";
            }
          }
        }

        $controller.="\nclass ".$modelName."Controller extends Controller\n{\n";

        //instantiate the index class
        $controller.="    public function index()\n    {\n";
        if ($with != '') {
          # code...
          $controller.="        $".lcfirst($modelName)."s = ".$modelName."::with(".$with.")->orderBy('id', 'ASC')->paginate(20);\n";
        }else{
          $controller.="        $".lcfirst($modelName)."s = ".$modelName."::orderBy('id', 'ASC')->paginate(20);\n";
        }
        $controller.="        return response()->json($".lcfirst($modelName)."s);";
        $controller.="\n    }\n";
        //Store function
        $controller.="
    public function store(Request $".""."request)\n    {";
        $rules_set="\n";
        $update_fields="            $".lcfirst($modelName)."=".$modelName."::findOrFail($"."id);\n";
        $stored_fields="            $".lcfirst($modelName)."= new ".$modelName.";\n";
        
        $myfile = fopen("/var/www/riverside/app/Http/Controllers/".$modelName."Controller.php", "w") or die("Unable to open file!");
        /*
         *   "Field": "first_name"
         *   "Type": "varchar(191)"
         *   "Null": "NO"
         *   "Key": ""
         *   "Default": null
         *   "Extra": ""
         */
        foreach ($fields as $field) {
            //Generate validation rules
            if($field->Field=="id" || $field->Field=="created_at" || $field->Field=="updated_at" || $field->Field=="deleted_at"){

            }else{
                if($field->Null!='YES'){
                    $rules_set.="            ".'"'.$field->Field.'"'." => 'required',\n";
                }
                 //generate store objects and exlude id and other autogenerated fields
                $stored_fields.="            $".lcfirst($modelName)."->".$field->Field." = $"."request->input('".$field->Field."');\n";
                $update_fields.="            $".lcfirst($modelName)."->".$field->Field." = $"."request->input('".$field->Field."');\n";
        
            }
        }
        $controller.="
        $".""."rules = [".$rules_set."        ];\n\n";
        $controller.="        $".""."validator = \\Validator::make($"."request->all(),$"."rules);\n";
        $controller.="        if ($".""."validator->fails()) {\n";
        $controller.="             return response()->json($"."validator, 422);\n        } else {\n";
        $controller.=$stored_fields."\n    ";
        $controller.="        try{\n";
        $controller.="                $".lcfirst($modelName)."->save();\n";
        if ($with != '') {
          $controller.="                $".lcfirst($modelName)." = ".$modelName."::find($".lcfirst($modelName)."->id)->load(".$with.");\n";
        }

        $controller.="                return response()->json($".lcfirst($modelName).");\n";
        $controller.="            } catch (\Illuminate\Database\QueryException $".""."e) {\n";
        $controller.="                return response()->json(['status' => 'error', 'message' => $".""."e->getMessage()]);\n";
        $controller.="            }\n";
        $controller.="        }\n";
        $controller.="    }\n";

        //Show one record function
        $controller.="
    public function show($"."id){\n";
        $controller.="        $".lcfirst($modelName)." = ".$modelName."::findOrFail($"."id);\n";
        if ($with != '') {
          $controller.="        $".lcfirst($modelName)."->load(".$with.");\n";
        }
        $controller.="        return response()->json($".lcfirst($modelName).");";
        $controller.="\n    }\n";


        //Update function
        $controller.="
    public function update(Request $"."request, $"."id)\n    {";
        $controller.="
        $".""."rules=[".$rules_set."\n        ];
        ";
        $controller.="$".""."validator = \\Validator::make($"."request->all(),$"."rules);\n";
        $controller.="         if ($".""."validator->fails()) {\n";
        $controller.="             return response()->json($"."validator, 422);\n        } else {\n";
        $controller.=$update_fields."\n    ";
        $controller.="        try{\n";
        $controller.="                $".lcfirst($modelName)."->save();\n";
        if ($with != '') {
          $controller.="                $".lcfirst($modelName)." = ".$modelName."::find($"."id)->load(".$with.");\n";
        }

        $controller.="                return response()->json($".lcfirst($modelName).");\n";
        $controller.="            }\n";
        $controller.="            catch (\Illuminate\Database\QueryException $".""."e){\n";
        $controller.="                return response()->json(['status' => 'error', 'message' => $".""."e->getMessage()]);\n";
        $controller.="            }\n";
        $controller.="        }\n";
        $controller.="    }\n";
        
       
        
        
        //Function to delete item
        $controller.="
    public function destroy($"."id){\n";
        $controller.="        try{\n";
        $controller.="            $".lcfirst($modelName)."=".$modelName."::findOrFail($"."id);\n";
        $controller.="            $".lcfirst($modelName)."->delete();\n";
        $controller.="            return response()->json($".lcfirst($modelName).",200);\n";
        $controller.="        }\n";
        $controller.="        catch (\Illuminate\Database\QueryException $".""."e){\n";
        $controller.="            return response()->json(['status' => 'error', 'message' => $".""."e->getMessage()]);\n";
        $controller.="        }\n";
        $controller.="    }\n}";


       fwrite($myfile, $controller);
       fclose($myfile);
    }

    public function generateModel($table){
      $fields = DB::connection('mysqlriverside')->select('show columns from ' . $table);

      $modelName = Pluralizer::singular(ucwords(preg_replace_callback('/_([a-z]?)/', function($match) {
        return strtoupper($match[1]);
      }, $table)));

      $model='<?php
namespace App\Models;
/**
 * (c) @aereng@gmail.com
 */

use Illuminate\Database\Eloquent\Model;

class '.$modelName.' extends Model
{';

        $timestamps = false;
        foreach ($fields as $field) {
          if ($field->Field == 'created_at') {
            $timestamps = true;
          }
          //Generate validation rules
          if(substr($field->Field, -3) == '_id'){

            $stringLength = strlen($field->Field)-3;

            // make a model name and import those models
            $importModelName = str_replace(' ', '', ucwords(str_replace('_', ' ', substr($field->Field,0, $stringLength))));

            $model.='
    public function '.lcfirst($importModelName).'()
    {
        return $this->belongsTo(\'App\Models\\'.$importModelName.'\');
    }
';
          }
        }
        if ($timestamps) {
          $model.='
    public $timestamps = false;
';
        }
        $model.='
}';


        $myfile = fopen("/var/www/riverside/app/Models/".$modelName.".php", "w") or die("Unable to open file!");

        fwrite($myfile, $model);
        fclose($myfile);

    }

    public function generateAPIRoutes($modelName){
        $myfile = fopen("api.php", "a") or die("Unable to open file!");
        fwrite($myfile, $modelName);
        fclose($myfile);
    }

    public function generateVue($table){
        $fields = DB::connection('mysqlriverside')->select('show columns from ' . $table);

        $modelName = Pluralizer::singular(ucwords(preg_replace_callback('/_([a-z]?)/', function($match) {
                return strtoupper($match[1]);
            }, $table)));

        $template ='<template>
  <div>
    <v-dialog v-model="dialog" max-width="500px">
      <v-btn slot="activator" color="primary" dark class="mb-2">New Item</v-btn>
      <v-card>
        <v-card-title>
          <span class="headline">{{ formTitle }}</span>
        </v-card-title>
        <v-form ref="form" v-model="valid" lazy-validation>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>';

        foreach ($fields as $field) {

          $fieldDisplay = Pluralizer::singular(ucwords(preg_replace_callback('/_([a-z]?)/', function($match) {
              return ' '.strtoupper($match[1]);
          }, $field->Field)));


          if($field->Field=="id" ||
            $field->Field=="created_at" ||
            $field->Field=="updated_at" ||
            $field->Field=="deleted_at"){}elseif (substr($field->Field, -3) == '_id') {
    
              $stringLength = strlen($field->Field)-3;

              // make a model name and import those models
              $itemsDisplay = str_replace(' ', '', ucwords(str_replace('_', ' ', substr($field->Field,0, $stringLength))));

              $fieldDisplay = ucwords(str_replace('_', ' ', substr($field->Field,0, $stringLength)));

              $template.='
              <v-flex xs12 sm12 md12>
                <v-select
                  :items="'.lcfirst($itemsDisplay).'s"
                  item-text="name"
                  item-value="id"
                  v-model="editedItem.'.$field->Field.'"
                  :rules="[v => !!v || \''.$fieldDisplay.' is Required\']"
                  label="'.$fieldDisplay.'">
                </v-select>
              </v-flex>';
            }elseif ($field->Type == 'datetime'||$field->Type == 'timestamps') {
              $template.='
                <v-flex xs12 sm12 md12>
                  <v-text-field
                    readonly
                    v-model="editedItem.'.$field->Field.'"
                    :rules="[v => !!v || \''.$fieldDisplay.' is Required\']"
                    label="'.$fieldDisplay.'"
                    @click="datePicker.'.$field->Field.' = true">
                  </v-text-field>
                  <v-date-picker
                    v-show="datePicker.'.$field->Field.'"
                    v-model="editedItem.'.$field->Field.'"
                    :landscape="landscape" :reactive="reactive">
                  </v-date-picker>
                </v-flex>';
            }else{

          $template.='
              <v-flex xs12 sm12 md12>
                <v-text-field
                  v-model="editedItem.'.$field->Field.'"
                  :rules="[v => !!v || \''.$fieldDisplay.' is Required\']"
                  label="'.$fieldDisplay.'">
                </v-text-field>
              </v-flex>';
            }
        }
      $template.='
            </v-layout>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" flat @click.native="close">Cancel</v-btn>
          <v-btn color="blue darken-1" :disabled="!valid" flat @click.native="save">Save</v-btn>
        </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>

    <v-card-title>
      '.$modelName.'
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="search"
        label="Search"
        single-line
        v-on:keyup.enter="initialize"
        hide-details>
      </v-text-field>
    </v-card-title>

    <v-data-table
      :headers="headers"
      :items="'.lcfirst($modelName).'s"
      hide-actions
      class="elevation-1"
    >
      <template slot="items" slot-scope="props">';

      // table iteration creating columns
      foreach ($fields as $key => $field) {
        if($field->Field=="id" ||
          $field->Field=="created_at" ||
          $field->Field=="updated_at" ||
          $field->Field=="deleted_at"){}elseif ($key === 1) {
            // first column
          $template.='
        <td>{{ props.item.'.$field->Field.' }}</td>';

        }elseif (substr($field->Field, -3) == '_id') {
    
          $stringLength = strlen($field->Field)-3;

          $fieldResource = substr($field->Field,0, $stringLength);

          $template.='
        <td class="text-xs-left">{{ props.item.'.$fieldResource.'.name }}</td>';

        }else{
          $template.='
        <td class="text-xs-left">{{ props.item.'.$field->Field.' }}</td>';
        }
      }
      // last column: action column
      $template.='
        <td class="justify-center layout px-0">
          <v-btn icon class="mx-0" @click="editItem(props.item)">
            <v-icon color="teal">edit</v-icon>
          </v-btn>
          <v-btn icon class="mx-0" @click="deleteItem(props.item)">
            <v-icon color="pink">delete</v-icon>
          </v-btn>
        </td>';

      $template.='
      </template>
    </v-data-table>
    <div class="text-xs-center">
      <v-pagination
        :length="length"
        :total-visible="pagination.visible"
        v-model="pagination.page"
        @input="initialize"
        circle>
      </v-pagination>
    </div>
  </div>
</template>
<script>
  import apiCall from \'../../utils/api\'
  export default {
    data: () => ({
';
          $template.='
      datePicker: {
';
      foreach ($fields as $key => $field) {
        if($field->Field=="id" ||
          $field->Field=="created_at" ||
          $field->Field=="updated_at" ||
          $field->Field=="deleted_at"){

        }elseif($field->Type == 'datetime'||$field->Type == 'timestamps'){


          $template.='
        '.$field->Field.': false,
';
        }
      }
          $template.="
      },
";
          $template.='
      valid: true,
      dialog: false,
      delete: false,
      saving: false,
      search: \'\',
      query: \'\',
      pagination: {
        page: 1,
        per_page: 0,
        total: 0,
        visible: 10
      },
      headers: [';

      foreach ($fields as $key => $field) {
        if($field->Field=="id" ||
          $field->Field=="created_at" ||
          $field->Field=="updated_at" ||
          $field->Field=="deleted_at"){}elseif (substr($field->Field, -3) == '_id') {
    
              $stringLength = strlen($field->Field)-3;

              $fieldValue = substr($field->Field,0, $stringLength);
              $fieldDisplay = ucwords(str_replace('_', ' ', substr($field->Field,0, $stringLength)));
              $template.='
        { text: \''.$fieldDisplay.'\', value: \''.$fieldValue.'\' },';

        }else{
          $fieldDisplay = Pluralizer::singular(ucwords(
            preg_replace_callback('/_([a-z]?)/', function($match) {
            return ' '.strtoupper($match[1]);
          }, $field->Field)));
          // first column
          $template.='
        { text: \''.$fieldDisplay.'\', value: \''.$field->Field.'\' },';
        }
      }
      // last action column
      $template.='
        { text: \'Actions\', value: \'name\', sortable: false }';

        $template.='
      ],
      '.lcfirst($modelName).'s: [],';

      foreach ($fields as $field) {
        if (substr($field->Field, -3) == '_id') {
  
          $stringLength = strlen($field->Field)-3;

          // make a model name and import those models
          $itemsDisplay = str_replace(' ', '', ucwords(str_replace('_', ' ', substr($field->Field,0, $stringLength))));

          $template.='
      '.lcfirst($itemsDisplay).'s: [],';

        }
      }

        $template.='
      editedIndex: -1,
      editedItem: {';

      foreach ($fields as $key => $field) {
          if($field->Field=="id" ||
            $field->Field=="created_at" ||
            $field->Field=="updated_at" ||
            $field->Field=="deleted_at"){
          }else{
            $init = ($field->Type == 'varchar(191)') ? '\'\'' : 0;
        $template.='
        '.$field->Field.': '.$init.',';
          }
      }

      $template.='
      },
      defaultItem: {';

      foreach ($fields as $key => $field) {
          if($field->Field=="id" ||
            $field->Field=="created_at" ||
            $field->Field=="updated_at" ||
            $field->Field=="deleted_at"){
          }else{
            $init = ($field->Type=="int(10) unsigned") ? 0 : '\'\'';
        $template.='
        '.$field->Field.': '.$init.',';
          }
      }

      $template.='
      }
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? \'New Item\' : \'Edit Item\'
      },

      length: function() {
        return Math.ceil(this.pagination.total / 10);
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      }
    },

    created () {
      this.initialize()
    },

    methods: {

      initialize () {

        this.query = \'page=\'+ this.pagination.page;
        if (this.search != \'\') {
            this.query = this.query+\'&search=\'+this.search;
        }

        apiCall({url: \'/api/'.strtolower($modelName).'?\' + this.query, method: \'GET\' })
        .then(resp => {
          console.log(resp)
          this.'.lcfirst($modelName).'s = resp.data;
          this.pagination.total = resp.total;
        })
        .catch(error => {
          console.log(error.response)
        })
';

        foreach ($fields as $field) {

          $fieldDisplay = Pluralizer::singular(ucwords(preg_replace_callback('/_([a-z]?)/', function($match) {
              return ' '.strtoupper($match[1]);
          }, $field->Field)));

          $stringLength = strlen($field->Field)-3;

          // make a model name and import those models
          $itemsDisplay = str_replace(' ', '', ucwords(str_replace('_', ' ', substr($field->Field,0, $stringLength))));


          if(substr($field->Field, -3) == '_id') {
    
      $template.='
        apiCall({url: \'/api/'.strtolower($modelName).'\', method: \'GET\' })
        .then(resp => {
          console.log(resp)
          this.'.lcfirst($itemsDisplay).'s = resp;
        })
        .catch(error => {
          console.log(error.response)
        })';
          }
        }

      $template.='
      },
      editItem (item) {
        this.editedIndex = this.'.lcfirst($modelName).'s.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {

        confirm(\'Are you sure you want to delete this item?\') && (this.delete = true)

        if (this.delete) {
          const index = this.'.lcfirst($modelName).'s.indexOf(item)
          this.'.lcfirst($modelName).'s.splice(index, 1)
          apiCall({url: \'/api/'.strtolower($modelName).'/\'+item.id, method: \'DELETE\' })
          .then(resp => {
            console.log(resp)
          })
          .catch(error => {
            console.log(error.response)
          })
        }

      },

      close () {
        this.dialog = false

        // if not saving reset dialog references to datatables
        if (!this.saving) {
          this.resetDialogReferences();
        }
      },

      resetDialogReferences() {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      },

      save () {

        this.saving = true;
        // update
        if (this.editedIndex > -1) {

          apiCall({url: \'/api/'.strtolower($modelName).'/\'+this.editedItem.id, data: this.editedItem, method: \'PUT\' })
          .then(resp => {
            Object.assign(this.'.lcfirst($modelName).'s[this.editedIndex], resp)
            console.log(resp)
            this.resetDialogReferences();
            this.saving = false;
          })
          .catch(error => {
            console.log(error.response)
          })

        // store
        } else {

          apiCall({url: \'/api/'.strtolower($modelName).'\', data: this.editedItem, method: \'POST\' })
          .then(resp => {
            this.'.lcfirst($modelName).'s.push(resp)
            console.log(resp)
            this.resetDialogReferences();
            this.saving = false;
          })
          .catch(error => {
            console.log(error.response)
          })
        }
        this.close()
      }
    }
  }
</script>';

        $componentFolder = "/var/www/riversidefrontend/src/components/".strtolower($modelName);
        if (!file_exists($componentFolder)) {
            mkdir($componentFolder, 0777, true);
        }

        $componentFile = fopen($componentFolder."/index.vue", "w") or die("Unable to open file!");
        fwrite($componentFile, $template);
        fclose($componentFile);
    }

    public function generateRelatedVue($parentTable,$table){
        $fields = DB::connection('mysqlriverside')->select('show columns from ' . $table);

        $modelName = Pluralizer::singular(ucwords(preg_replace_callback('/_([a-z]?)/', function($match) {
                return strtoupper($match[1]);
            }, $table)));

        $modelNameOfParent = Pluralizer::singular(ucwords(preg_replace_callback('/_([a-z]?)/', function($match) {
                return strtoupper($match[1]);
            }, $parentTable)));

        $template ='<template>
  <div>
    <v-card-title>
      {{testType.name}}
    </v-card-title>
    <v-layout row>
      <v-dialog v-model="dialog" max-width="500px">
        <v-btn
          outline
          small
          color="primary"
          slot="activator"
          flat>
          New '.$modelName.'
          <v-icon right dark>playlist_add</v-icon>
        </v-btn>
        <v-card>
          <v-toolbar dark color="primary" class="elevation-0">
            <v-toolbar-title>'.$modelName.'</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn round outline color="blue lighten-1" flat @click.native="close">
              Cancel
              <v-icon right dark>close</v-icon>
            </v-btn>
          </v-toolbar>
          <v-card-text>';

        foreach ($fields as $field) {

          $fieldDisplay = Pluralizer::singular(ucwords(preg_replace_callback('/_([a-z]?)/', function($match) {
              return ' '.strtoupper($match[1]);
          }, $field->Field)));


          if($field->Field=="id" ||
            $field->Field=="created_at" ||
            $field->Field=="updated_at" ||
            $field->Field=="deleted_at"){}elseif (substr($field->Field, -3) == '_id') {
    
              $stringLength = strlen($field->Field)-3;

              // make a model name and import those models
              $itemsDisplay = str_replace(' ', '', ucwords(str_replace('_', ' ', substr($field->Field,0, $stringLength))));

              $fieldDisplay = ucwords(str_replace('_', ' ', substr($field->Field,0, $stringLength)));

              $template.='
              <v-flex xs12 sm12 md12>
                <v-select
                  :items="'.lcfirst($itemsDisplay).'s"
                  item-text="name"
                  item-value="id"
                  v-model="editedItem.'.$field->Field.'"
                  :rules="[v => !!v || \''.$fieldDisplay.' is Required\']"
                  label="'.$fieldDisplay.'">
                </v-select>
              </v-flex>';
            }elseif ($field->Type == 'datetime'||$field->Type == 'timestamps') {
              $template.='
                <v-flex xs12 sm12 md12>
                  <v-text-field
                    readonly
                    v-model="editedItem.'.$field->Field.'"
                    :rules="[v => !!v || \''.$fieldDisplay.' is Required\']"
                    label="'.$fieldDisplay.'"
                    @click="datePicker.'.$field->Field.' = true">
                  </v-text-field>
                  <v-date-picker
                    v-show="datePicker.'.$field->Field.'"
                    v-model="editedItem.'.$field->Field.'"
                    :landscape="landscape" :reactive="reactive">
                  </v-date-picker>
                </v-flex>';
            }else{

          $template.='
              <v-flex xs12 sm12 md12>
                <v-text-field
                  v-model="editedItem.'.$field->Field.'"
                  :rules="[v => !!v || \''.$fieldDisplay.' is Required\']"
                  label="'.$fieldDisplay.'">
                </v-text-field>
              </v-flex>';
            }
        }
      $template.='
            <v-flex xs3 offset-xs9 text-xs-left>
              <v-btn round outline xs12 sm6 color="blue darken-1" :disabled="!valid" @click.native="save">
                Save <v-icon right dark>cloud_upload</v-icon>
              </v-btn>
            </v-flex>
          </v-card-text>
        </v-card>
      </v-dialog>
    </v-layout>

      <v-divider></v-divider>
      <v-layout child-flex>

    <v-data-table
      :headers="headers"
      :items="'.lcfirst($modelName).'s"
      hide-actions
      class="elevation-1"
    >
      <template slot="items" slot-scope="props">';

      // table iteration creating columns
      foreach ($fields as $key => $field) {
        if($field->Field=="id" ||
          $field->Field=="created_at" ||
          $field->Field=="updated_at" ||
          $field->Field=="deleted_at"){}elseif ($key === 1) {
            // first column
          $template.='
        <td>{{ props.item.'.$field->Field.' }}</td>';

        }elseif (substr($field->Field, -3) == '_id') {
    
          $stringLength = strlen($field->Field)-3;

          $fieldResource = substr($field->Field,0, $stringLength);

          $template.='
        <td class="text-xs-left">{{ props.item.'.$fieldResource.'.name }}</td>';

        }else{
          $template.='
        <td class="text-xs-left">{{ props.item.'.$field->Field.' }}</td>';
        }
      }
      // last column: action column
      $template.='
        <td class="justify-center layout px-0">
          <v-btn icon class="mx-0" @click="editItem(props.item)">
            <v-icon color="teal">edit</v-icon>
          </v-btn>
          <v-btn icon class="mx-0" @click="deleteItem(props.item)">
            <v-icon color="pink">delete</v-icon>
          </v-btn>
        </td>';

      $template.='
          </template>
        </v-data-table>
      </v-layout>
  </div>
</template>
<script>
  import apiCall from \'../../utils/api\'
  export default {
    data: () => ({
';
          $template.='
      datePicker: {
';
      foreach ($fields as $key => $field) {
        if($field->Field=="id" ||
          $field->Field=="created_at" ||
          $field->Field=="updated_at" ||
          $field->Field=="deleted_at"){

        }elseif($field->Type == 'datetime'||$field->Type == 'timestamps'){


          $template.='
        '.$field->Field.': false,
';
        }
      }
          $template.="
      },
";
          $template.='
      valid: true,
      dialog: false,
      delete: false,
      saving: false,
      headers: [';

      foreach ($fields as $key => $field) {
        if($field->Field=="id" ||
          $field->Field=="created_at" ||
          $field->Field=="updated_at" ||
          $field->Field=="deleted_at"){}elseif (substr($field->Field, -3) == '_id') {
    
              $stringLength = strlen($field->Field)-3;

              $fieldValue = substr($field->Field,0, $stringLength);
              $fieldDisplay = ucwords(str_replace('_', ' ', substr($field->Field,0, $stringLength)));
              $template.='
        { text: \''.$fieldDisplay.'\', value: \''.$fieldValue.'\' },';

        }else{
          $fieldDisplay = Pluralizer::singular(ucwords(
            preg_replace_callback('/_([a-z]?)/', function($match) {
            return ' '.strtoupper($match[1]);
          }, $field->Field)));
          // first column
          $template.='
        { text: \''.$fieldDisplay.'\', value: \''.$field->Field.'\' },';
        }
      }
      // last action column
      $template.='
        { text: \'Actions\', value: \'name\', sortable: false }';

        $template.='
      ],
      '.lcfirst($modelName).'s: [],';

      foreach ($fields as $field) {
        if (substr($field->Field, -3) == '_id') {
  
          $stringLength = strlen($field->Field)-3;

          // make a model name and import those models
          $itemsDisplay = str_replace(' ', '', ucwords(str_replace('_', ' ', substr($field->Field,0, $stringLength))));

          $template.='
      '.lcfirst($itemsDisplay).'s: [],';

        }
      }

        $template.='
      editedIndex: -1,
      editedItem: {';

      foreach ($fields as $key => $field) {
          if($field->Field=="id" ||
            $field->Field=="created_at" ||
            $field->Field=="updated_at" ||
            $field->Field=="deleted_at"){
          }else{
            $init = ($field->Type == 'varchar(191)') ? '\'\'' : 0;
        $template.='
        '.$field->Field.': '.$init.',';
          }
      }

      $template.='
      },
      defaultItem: {';

      foreach ($fields as $key => $field) {
          if($field->Field=="id" ||
            $field->Field=="created_at" ||
            $field->Field=="updated_at" ||
            $field->Field=="deleted_at"){
          }else{
            $init = ($field->Type=="int(10) unsigned") ? 0 : '\'\'';
        $template.='
        '.$field->Field.': '.$init.',';
          }
      }

      $template.='
      }
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? \'New Item\' : \'Edit Item\'
      },

    },

    watch: {
      dialog (val) {
        val || this.close()
      }
    },

    created () {
      this.initialize()
    },

    methods: {

      initialize () {

        apiCall({url: \'/api/'.strtolower($modelName).'\', method: \'GET\' })
        .then(resp => {
          console.log(resp)
          this.'.lcfirst($modelName).'s = resp;
        })
        .catch(error => {
          console.log(error.response)
        })
';

        foreach ($fields as $field) {

          $fieldDisplay = Pluralizer::singular(ucwords(preg_replace_callback('/_([a-z]?)/', function($match) {
              return ' '.strtoupper($match[1]);
          }, $field->Field)));

          $stringLength = strlen($field->Field)-3;

          // make a model name and import those models
          $itemsDisplay = str_replace(' ', '', ucwords(str_replace('_', ' ', substr($field->Field,0, $stringLength))));


          if(substr($field->Field, -3) == '_id') {
    
      $template.='
        apiCall({url: \'/api/'.strtolower($modelName).'\'+parseInt(this.$route.params.'.lcfirst($modelName).'Id), method: \'GET\' })
        .then(resp => {
          console.log(resp)
          this.'.lcfirst($itemsDisplay).'s = resp;
        })
        .catch(error => {
          console.log(error.response)
        })';
          }
        }

      $template.='
      },
      editItem (item) {
        this.editedIndex = this.'.lcfirst($modelName).'s.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {

        confirm(\'Are you sure you want to delete this item?\') && (this.delete = true)

        if (this.delete) {
          const index = this.'.lcfirst($modelName).'s.indexOf(item)
          this.'.lcfirst($modelName).'s.splice(index, 1)
          apiCall({url: \'/api/'.strtolower($modelName).'/\'+item.id, method: \'DELETE\' })
          .then(resp => {
            console.log(resp)
          })
          .catch(error => {
            console.log(error.response)
          })
        }

      },

      close () {
        this.dialog = false

        // if not saving reset dialog references to datatables
        if (!this.saving) {
          this.resetDialogReferences();
        }
      },

      resetDialogReferences() {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      },

      save () {

        this.saving = true;
        // update
        if (this.editedIndex > -1) {

          apiCall({url: \'/api/'.strtolower($modelName).'/\'+this.editedItem.id, data: this.editedItem, method: \'PUT\' })
          .then(resp => {
            Object.assign(this.'.lcfirst($modelName).'s[this.editedIndex], resp)
            console.log(resp)
            this.resetDialogReferences();
            this.saving = false;
          })
          .catch(error => {
            console.log(error.response)
          })

        // store
        } else {

          apiCall({url: \'/api/'.strtolower($modelName).'\', data: this.editedItem, method: \'POST\' })
          .then(resp => {
            this.'.lcfirst($modelName).'s.push(resp)
            console.log(resp)
            this.resetDialogReferences();
            this.saving = false;
          })
          .catch(error => {
            console.log(error.response)
          })
        }
        this.close()
      }
    }
  }
</script>';

        $componentFolder = "/var/www/riverside/resources/assets/js/components/".strtolower($modelName);
        if (!file_exists($componentFolder)) {
            mkdir($componentFolder, 0777, true);
        }

        $componentFile = fopen($componentFolder."/index.vue", "w") or die("Unable to open file!");
        fwrite($componentFile, $template);
        fclose($componentFile);


        $routing='
          <v-btn
            outline
            small
            :to="{ name: \''.$modelName.'\', params: { '.lcfirst($modelName).'Id:props.item.id} }"
            title="'.$modelName.'s"
            color="blue"
            flat
            v-if="$can(\'play_prediction\')">
            Measures
            <v-icon right dark>list</v-icon>
          </v-btn>

    {
      path: \'/'.strtolower($modelNameOfParent).'/'.strtolower($modelName).'/:'.lcfirst($modelName).'\',
      name: \''.$modelName.'\',
      component: '.$modelName.',
      beforeEnter: ifAuthenticated,
    },
';


// information on the side side,

        $routingFile = fopen("/var/www/playground/storage/logs/routing.php", "w") or die("Unable to open file!");
        fwrite($routingFile, $routing);
        fclose($routingFile);
    }

}
