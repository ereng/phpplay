<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use DB;

class SMSViewGen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:views';

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
      $views=[
        [
          'path' => '/var/www/schmgtsys/resources/views/configuration/assessmentcategory/create.blade.php',
          'name' => 'assessmentcategory',
          'action' => 'Create Assessment Category',
          'breadcrumb' => "\n    <li><a href=\"{{URL::route('assessmentcategory.index')}}\">Assessment Category</a></li>\n    <li class=\"active\">Create Assessment Category</li>",
          'method' => 'POST',
          'route' => '/assessmentcategory/store',
          'cancel-route' => '/assessmentcategory',
          'page' => '/assessmentcategory/create',
          'fields' => [
          
            [
              'type'=>'text',
              'label'=>'Name',
              'value'=>'name',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/configuration/assessmentcategory/edit.blade.php',
          'name' => 'assessmentcategory',
          'action' => 'Edit Assessment Category',
          'breadcrumb' => "\n    <li><a href=\"{{URL::route('assessmentcategory.index')}}\">Assessment Category</a></li>\n    <li class=\"active\">Edit Assessment Category</li>",
          'method' => 'PUT',
          'route' => '/assessmentcategory/update',
          'cancel-route' => '/assessmentcategory',
          'page' => '/assessmentcategory/edit',
          'fields' => [
          
            [
              'type'=>'text',
              'label'=>'Name',
              'value'=>'name',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/configuration/assessmentcategory/index.blade.php',
          'name' => 'assessmentcategory',
          'action' => ' Assessment Category',
          'breadcrumb' => "\n    <li class=\"active\"> Assessment Category</li>",
          'method' => '',
          'route' => '/assessmentcategory/index',
          'cancel-route' => '/assessmentcategory',
          'page' => '/assessmentcategory/index',
          'fields' => [
          
            [
              'type'=>'text',
              'label'=>'Name',
              'value'=>'name',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/configuration/religion/create.blade.php',
          'name' => 'religion',
          'action' => 'Create Religion',
          'breadcrumb' => "\n    <li><a href=\"{{URL::route('religion.index')}}\">Religion</a></li>\n    <li class=\"active\">Create Religion</li>",
          'method' => 'POST',
          'route' => '/religion/store',
          'cancel-route' => '/religion',
          'page' => '/religion/create',
          'fields' => [
          
            [
              'type'=>'text',
              'label'=>'Name',
              'value'=>'name',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/configuration/religion/edit.blade.php',
          'name' => 'religion',
          'action' => 'Edit Religion',
          'breadcrumb' => "\n    <li><a href=\"{{URL::route('religion.index')}}\">Religion</a></li>\n    <li class=\"active\">Edit Religion</li>",
          'method' => 'PUT',
          'route' => '/religion/update',
          'cancel-route' => '/religion',
          'page' => '/religion/edit',
          'fields' => [
          
            [
              'type'=>'text',
              'label'=>'Name',
              'value'=>'name',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/configuration/religion/index.blade.php',
          'name' => 'religion',
          'action' => ' Religion',
          'breadcrumb' => "\n    <li class=\"active\"> Religion</li>",
          'method' => '',
          'route' => '/religion/index',
          'cancel-route' => '/religion',
          'page' => '/religion/index',
          'fields' => [
          
            [
              'type'=>'text',
              'label'=>'Name',
              'value'=>'name',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/configuration/nationality/create.blade.php',
          'name' => 'nationality',
          'action' => 'Create Nationality',
          'breadcrumb' => "\n    <li><a href=\"{{URL::route('nationality.index')}}\">Nationality</a></li>\n    <li class=\"active\">Create Nationality</li>",
          'method' => 'POST',
          'route' => '/nationality/store',
          'cancel-route' => '/nationality',
          'page' => '/nationality/create',
          'fields' => [
          
            [
              'type'=>'text',
              'label'=>'Name',
              'value'=>'name',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/configuration/nationality/edit.blade.php',
          'name' => 'nationality',
          'action' => 'Edit Nationality',
          'breadcrumb' => "\n    <li><a href=\"{{URL::route('nationality.index')}}\">Nationality</a></li>\n    <li class=\"active\">Edit Nationality</li>",
          'method' => 'PUT',
          'route' => '/nationality/update',
          'cancel-route' => '/nationality',
          'page' => '/nationality/edit',
          'fields' => [
          
            [
              'type'=>'text',
              'label'=>'Name',
              'value'=>'name',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/configuration/nationality/index.blade.php',
          'name' => 'nationality',
          'action' => ' Nationality',
          'breadcrumb' => "\n    <li class=\"active\"> Nationality</li>",
          'method' => '',
          'route' => '/nationality/index',
          'cancel-route' => '/nationality',
          'page' => '/nationality/index',
          'fields' => [
          
            [
              'type'=>'text',
              'label'=>'Name',
              'value'=>'name',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/configuration/subject/combination/create.blade.php',
          'name' => 'combination',
          'action' => 'Create Combination',
          'breadcrumb' => "\n    <li><a href=\"{{URL::route('combination.index')}}\">Combination</a></li>\n    <li class=\"active\">Create Combination</li>",
          'method' => 'POST',
          'route' => '/combination/store',
          'cancel-route' => '/combination',
          'page' => '/combination/create',
          'fields' => [
          
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/configuration/subject/combination/edit.blade.php',
          'name' => 'combination',
          'action' => 'Edit Combination',
          'breadcrumb' => "\n    <li><a href=\"{{URL::route('combination.index')}}\">Combination</a></li>\n    <li class=\"active\">Edit Combination</li>",
          'method' => 'PUT',
          'route' => '/combination/update',
          'cancel-route' => '/combination',
          'page' => '/combination/edit',
          'fields' => [
          
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/configuration/subject/combination/index.blade.php',
          'name' => 'combination',
          'action' => ' Combination',
          'breadcrumb' => "\n    <li class=\"active\"> Combination</li>",
          'method' => '',
          'route' => '/combination/index',
          'cancel-route' => '/combination',
          'page' => '/combination/index',
          'fields' => [
          
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/student/parent/create.blade.php',
          'name' => 'parent',
          'action' => 'Create Parent',
          'breadcrumb' => "\n    <li><a href=\"{{URL::route('parent.index')}}\">Parent</a></li>\n    <li class=\"active\">Create Parent</li>",
          'method' => 'POST',
          'route' => '/parent/store',
          'cancel-route' => '/parent',
          'page' => '/parent/create',
          'fields' => [
          
            [
              'type'=>'text',
              'label'=>'First Name',
              'value'=>'first_name',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Last Name',
              'value'=>'last_name',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Telephone',
              'value'=>'telephone',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Address',
              'value'=>'address',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Occupation',
              'value'=>'occupation',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Relationship',
              'value'=>'relationship',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/student/parent/edit.blade.php',
          'name' => 'parent',
          'action' => 'Edit Parent',
          'breadcrumb' => "\n    <li><a href=\"{{URL::route('parent.index')}}\">Parent</a></li>\n    <li class=\"active\">Edit Parent</li>",
          'method' => 'PUT',
          'route' => '/parent/update',
          'cancel-route' => '/parent',
          'page' => '/parent/edit',
          'fields' => [
          
            [
              'type'=>'text',
              'label'=>'First Name',
              'value'=>'first_name',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Last Name',
              'value'=>'last_name',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Telephone',
              'value'=>'telephone',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Address',
              'value'=>'address',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Occupation',
              'value'=>'occupation',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Relationship',
              'value'=>'relationship',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/student/parent/index.blade.php',
          'name' => 'parent',
          'action' => ' Parent',
          'breadcrumb' => "\n    <li class=\"active\"> Parent</li>",
          'method' => '',
          'route' => '/parent/index',
          'cancel-route' => '/parent',
          'page' => '/parent/index',
          'fields' => [
          
            [
              'type'=>'text',
              'label'=>'First Name',
              'value'=>'first_name',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Last Name',
              'value'=>'last_name',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Telephone',
              'value'=>'telephone',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/assessment/result/create.blade.php',
          'name' => 'result',
          'action' => 'Create Result',
          'breadcrumb' => "\n    <li><a href=\"{{URL::route('result.index')}}\">Result</a></li>\n    <li class=\"active\">Create Result</li>",
          'method' => 'POST',
          'route' => '/result/store',
          'cancel-route' => '/result',
          'page' => '/result/create',
          'fields' => [
          
            [
              'type'=>'select',
              'label'=>'Assesment',
              'value'=>'assesment_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Student',
              'value'=>'student_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Paper',
              'value'=>'paper_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Subject',
              'value'=>'subject_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Mark',
              'value'=>'mark',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/assessment/result/edit.blade.php',
          'name' => 'result',
          'action' => 'Edit Result',
          'breadcrumb' => "\n    <li><a href=\"{{URL::route('result.index')}}\">Result</a></li>\n    <li class=\"active\">Edit Result</li>",
          'method' => 'PUT',
          'route' => '/result/update',
          'cancel-route' => '/result',
          'page' => '/result/edit',
          'fields' => [
          
            [
              'type'=>'select',
              'label'=>'Assesment',
              'value'=>'assesment_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Student',
              'value'=>'student_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Paper',
              'value'=>'paper_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Subject',
              'value'=>'subject_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Mark',
              'value'=>'mark',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/assessment/result/index.blade.php',
          'name' => 'result',
          'action' => ' Result',
          'breadcrumb' => "\n    <li class=\"active\"> Result</li>",
          'method' => '',
          'route' => '/result/index',
          'cancel-route' => '/result',
          'page' => '/result/index',
          'fields' => [
          
            [
              'type'=>'select',
              'label'=>'Student',
              'value'=>'student_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Subject',
              'value'=>'subject_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Paper',
              'value'=>'paper_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Mark',
              'value'=>'mark',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/configuration/class/create.blade.php',
          'name' => 'class',
          'action' => 'Create Class',
          'breadcrumb' => "\n    <li><a href=\"{{URL::route('class.index')}}\">Class</a></li>\n    <li class=\"active\">Create Class</li>",
          'method' => 'POST',
          'route' => '/class/store',
          'cancel-route' => '/class',
          'page' => '/class/create',
          'fields' => [
          
            [
              'type'=>'text',
              'label'=>'Code',
              'value'=>'code',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Name',
              'value'=>'name',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/configuration/class/edit.blade.php',
          'name' => 'class',
          'action' => 'Edit Class',
          'breadcrumb' => "\n    <li><a href=\"{{URL::route('class.index')}}\">Class</a></li>\n    <li class=\"active\">Edit Class</li>",
          'method' => 'PUT',
          'route' => '/class/update',
          'cancel-route' => '/class',
          'page' => '/class/edit',
          'fields' => [
          
            [
              'type'=>'text',
              'label'=>'Code',
              'value'=>'code',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Name',
              'value'=>'name',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/configuration/class/index.blade.php',
          'name' => 'class',
          'action' => ' Class',
          'breadcrumb' => "\n    <li class=\"active\"> Class</li>",
          'method' => '',
          'route' => '/class/index',
          'cancel-route' => '/class',
          'page' => '/class/index',
          'fields' => [
          
            [
              'type'=>'text',
              'label'=>'Code',
              'value'=>'code',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Name',
              'value'=>'name',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/configuration/class/stream/create.blade.php',
          'name' => 'stream',
          'action' => 'Create Stream',
          'breadcrumb' => "\n    <li><a href=\"{{URL::route('stream.index')}}\">Stream</a></li>\n    <li class=\"active\">Create Stream</li>",
          'method' => 'POST',
          'route' => '/stream/store',
          'cancel-route' => '/stream',
          'page' => '/stream/create',
          'fields' => [
          
            [
              'type'=>'select',
              'label'=>'Stream Category',
              'value'=>'stream_category_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Class',
              'value'=>'class_id',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/configuration/class/stream/edit.blade.php',
          'name' => 'stream',
          'action' => 'Edit Stream',
          'breadcrumb' => "\n    <li><a href=\"{{URL::route('stream.index')}}\">Stream</a></li>\n    <li class=\"active\">Edit Stream</li>",
          'method' => 'PUT',
          'route' => '/stream/update',
          'cancel-route' => '/stream',
          'page' => '/stream/edit',
          'fields' => [
          
            [
              'type'=>'select',
              'label'=>'Stream Category',
              'value'=>'stream_category_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Class',
              'value'=>'class_id',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/configuration/class/stream/index.blade.php',
          'name' => 'stream',
          'action' => ' Stream',
          'breadcrumb' => "\n    <li class=\"active\"> Stream</li>",
          'method' => '',
          'route' => '/stream/index',
          'cancel-route' => '/stream',
          'page' => '/stream/index',
          'fields' => [
          
            [
              'type'=>'select',
              'label'=>'Stream Category',
              'value'=>'stream_category_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Class',
              'value'=>'class_id',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/student/create.blade.php',
          'name' => 'student',
          'action' => 'Create Student',
          'breadcrumb' => "\n    <li><a href=\"{{URL::route('student.index')}}\">Student</a></li>\n    <li class=\"active\">Create Student</li>",
          'method' => 'POST',
          'route' => '/student/store',
          'cancel-route' => '/student',
          'page' => '/student/create',
          'fields' => [
          
            [
              'type'=>'text',
              'label'=>'First Name',
              'value'=>'first_name',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Last Name',
              'value'=>'last_name',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Stream',
              'value'=>'stream_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Class',
              'value'=>'class_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Religion',
              'value'=>'religion_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Nationality',
              'value'=>'nationality_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Parent',
              'value'=>'parent_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Date of Birth',
              'value'=>'dob',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Gender',
              'value'=>'gender_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Photo',
              'value'=>'photo_path',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Reg No',
              'value'=>'reg_no',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Section',
              'value'=>'section',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/student/edit.blade.php',
          'name' => 'student',
          'action' => 'Edit Student',
          'breadcrumb' => "\n    <li><a href=\"{{URL::route('student.index')}}\">Student</a></li>\n    <li class=\"active\">Edit Student</li>",
          'method' => 'PUT',
          'route' => '/student/update',
          'cancel-route' => '/student',
          'page' => '/student/edit',
          'fields' => [
          
            [
              'type'=>'text',
              'label'=>'First Name',
              'value'=>'first_name',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Last Name',
              'value'=>'last_name',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Stream',
              'value'=>'stream_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Class',
              'value'=>'class_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Religion',
              'value'=>'religion_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Nationality',
              'value'=>'nationality_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Parent',
              'value'=>'parent_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Date of Birth',
              'value'=>'dob',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Gender',
              'value'=>'gender_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Photo Path',
              'value'=>'photo_path',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Reg No',
              'value'=>'reg_no',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Section',
              'value'=>'section',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/student/index.blade.php',
          'name' => 'student',
          'action' => ' Student',
          'breadcrumb' => "\n    <li class=\"active\"> Student</li>",
          'method' => '',
          'route' => '/student/index',
          'cancel-route' => '/student',
          'page' => '/student/index',
          'fields' => [
          
            [
              'type'=>'text',
              'label'=>'First Name',
              'value'=>'first_name',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Last Name',
              'value'=>'last_name',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Reg No',
              'value'=>'reg_no',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Class',
              'value'=>'class_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Parent',
              'value'=>'parent_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Gender',
              'value'=>'gender_id',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/configuration/subjectteacher/create.blade.php',
          'name' => 'subjectteacher',
          'action' => 'Create Subject Teacher',
          'breadcrumb' => "\n    <li><a href=\"{{URL::route('subjectteacher.index')}}\">Subject Teacher</a></li>\n    <li class=\"active\">Create Subject Teacher</li>",
          'method' => 'POST',
          'route' => '/subjectteacher/store',
          'cancel-route' => '/subjectteacher',
          'page' => '/subjectteacher/create',
          'fields' => [
          
            [
              'type'=>'select',
              'label'=>'Teacher User',
              'value'=>'teacher_user_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Subject',
              'value'=>'subject_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Paper',
              'value'=>'paper_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Stream',
              'value'=>'stream_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Enabled',
              'value'=>'enabled',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/configuration/subjectteacher/edit.blade.php',
          'name' => 'subjectteacher',
          'action' => 'Edit Subject Teacher',
          'breadcrumb' => "\n    <li><a href=\"{{URL::route('subjectteacher.index')}}\">Subject Teacher</a></li>\n    <li class=\"active\">Edit Subject Teacher</li>",
          'method' => 'PUT',
          'route' => '/subjectteacher/update',
          'cancel-route' => '/subjectteacher',
          'page' => '/subjectteacher/edit',
          'fields' => [
          
            [
              'type'=>'select',
              'label'=>'Teacher User',
              'value'=>'teacher_user_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Subject',
              'value'=>'subject_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Paper',
              'value'=>'paper_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Stream',
              'value'=>'stream_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Enabled',
              'value'=>'enabled',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/configuration/subjectteacher/index.blade.php',
          'name' => 'subjectteacher',
          'action' => ' Subject Teacher',
          'breadcrumb' => "\n    <li class=\"active\"> Subject Teacher</li>",
          'method' => '',
          'route' => '/subjectteacher/index',
          'cancel-route' => '/subjectteacher',
          'page' => '/subjectteacher/index',
          'fields' => [
          
            [
              'type'=>'select',
              'label'=>'Teacher User',
              'value'=>'teacher_user_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Subject',
              'value'=>'subject_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Stream',
              'value'=>'stream_id',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/assessment/create.blade.php',
          'name' => 'assessment',
          'action' => 'Create Assessment',
          'breadcrumb' => "\n    <li><a href=\"{{URL::route('assessment.index')}}\">Assessment</a></li>\n    <li class=\"active\">Create Assessment</li>",
          'method' => 'POST',
          'route' => '/assessment/store',
          'cancel-route' => '/assessment',
          'page' => '/assessment/create',
          'fields' => [
          
            [
              'type'=>'select',
              'label'=>'Assessment Category',
              'value'=>'assessment_category_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Stream',
              'value'=>'stream_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Assesment Date',
              'value'=>'assesment_date',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Assesment Duration',
              'value'=>'assesment_duration',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/assessment/edit.blade.php',
          'name' => 'assessment',
          'action' => 'Edit Assessment',
          'breadcrumb' => "\n    <li><a href=\"{{URL::route('assessment.index')}}\">Assessment</a></li>\n    <li class=\"active\">Edit Assessment</li>",
          'method' => 'PUT',
          'route' => '/assessment/update',
          'cancel-route' => '/assessment',
          'page' => '/assessment/edit',
          'fields' => [
          
            [
              'type'=>'select',
              'label'=>'Assessment Category',
              'value'=>'assessment_category_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Stream',
              'value'=>'stream_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Assesment Date',
              'value'=>'assesment_date',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Assesment Duration',
              'value'=>'assesment_duration',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/assessment/index.blade.php',
          'name' => 'assessment',
          'action' => ' Assessment',
          'breadcrumb' => "\n    <li class=\"active\"> Assessment</li>",
          'method' => '',
          'route' => '/assessment/index',
          'cancel-route' => '/assessment',
          'page' => '/assessment/index',
          'fields' => [
          
            [
              'type'=>'select',
              'label'=>'Assessment Category',
              'value'=>'assessment_category_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Stream',
              'value'=>'stream_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Assesment Date',
              'value'=>'assesment_date',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Assesment Duration',
              'value'=>'assesment_duration',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/configuration/subject/create.blade.php',
          'name' => 'subject',
          'action' => 'Create Subject',
          'breadcrumb' => "\n    <li><a href=\"{{URL::route('subject.index')}}\">Subject</a></li>\n    <li class=\"active\">Create Subject</li>",
          'method' => 'POST',
          'route' => '/subject/store',
          'cancel-route' => '/subject',
          'page' => '/subject/create',
          'fields' => [
          
            [
              'type'=>'text',
              'label'=>'Code',
              'value'=>'code',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Name',
              'value'=>'name',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Subject Category',
              'value'=>'subject_category_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Education Level',
              'value'=>'education_level_id',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/configuration/subject/edit.blade.php',
          'name' => 'subject',
          'action' => 'Edit Subject',
          'breadcrumb' => "\n    <li><a href=\"{{URL::route('subject.index')}}\">Subject</a></li>\n    <li class=\"active\">Edit Subject</li>",
          'method' => 'PUT',
          'route' => '/subject/update',
          'cancel-route' => '/subject',
          'page' => '/subject/edit',
          'fields' => [
          
            [
              'type'=>'text',
              'label'=>'Code',
              'value'=>'code',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Name',
              'value'=>'name',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Subject Category',
              'value'=>'subject_category_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Education Level',
              'value'=>'education_level_id',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/configuration/subject/index.blade.php',
          'name' => 'subject',
          'action' => ' Subject',
          'breadcrumb' => "\n    <li class=\"active\"> Subject</li>",
          'method' => '',
          'route' => '/subject/index',
          'cancel-route' => '/subject',
          'page' => '/subject/index',
          'fields' => [
          
            [
              'type'=>'text',
              'label'=>'Code',
              'value'=>'code',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Name',
              'value'=>'name',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Subject Category',
              'value'=>'subject_category_id',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Education Level',
              'value'=>'education_level_id',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/configuration/subject/paper/create.blade.php',
          'name' => 'paper',
          'action' => 'Create Paper',
          'breadcrumb' => "\n    <li><a href=\"{{URL::route('paper.index')}}\">Paper</a></li>\n    <li class=\"active\">Create Paper</li>",
          'method' => 'POST',
          'route' => '/paper/store',
          'cancel-route' => '/paper',
          'page' => '/paper/create',
          'fields' => [
          
            [
              'type'=>'text',
              'label'=>'Code',
              'value'=>'code',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Name',
              'value'=>'name',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Subject',
              'value'=>'subject_id',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/configuration/subject/paper/edit.blade.php',
          'name' => 'paper',
          'action' => 'Edit Paper',
          'breadcrumb' => "\n    <li><a href=\"{{URL::route('paper.index')}}\">Paper</a></li>\n    <li class=\"active\">Edit Paper</li>",
          'method' => 'PUT',
          'route' => '/paper/update',
          'cancel-route' => '/paper',
          'page' => '/paper/edit',
          'fields' => [
          
            [
              'type'=>'text',
              'label'=>'Code',
              'value'=>'code',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Name',
              'value'=>'name',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Subject',
              'value'=>'subject_id',
              'init'=>'\'\'',
            ],
          ],
        ],
        [
          'path' => '/var/www/schmgtsys/resources/views/configuration/subject/paper/index.blade.php',
          'name' => 'paper',
          'action' => ' Paper',
          'breadcrumb' => "\n    <li class=\"active\"> Paper</li>",
          'method' => '',
          'route' => '/paper/index',
          'cancel-route' => '/paper',
          'page' => '/paper/index',
          'fields' => [
          
            [
              'type'=>'text',
              'label'=>'Code',
              'value'=>'code',
              'init'=>'\'\'',
            ],
            [
              'type'=>'text',
              'label'=>'Name',
              'value'=>'name',
              'init'=>'\'\'',
            ],
            [
              'type'=>'select',
              'label'=>'Subject',
              'value'=>'subject_id',
              'init'=>'\'\'',
            ],
          ],
        ],
      ];

    foreach ($views as $view) {
    echo "Created ";
    echo $view['path'];
    echo "\n";
    $template = '';
    $template.='@extends(\'layouts.authenticated\')

@section(\'content\')
<div id="page-wrapper">
  <ol class="breadcrumb">
    <li><a href="{{URL::route(\'home\')}}">Home</a></li>'.$view['breadcrumb'].'
  </ol>';
    if ($view['method'] == '') {

    $template.='
  <div class="row">
    <div class="col-lg-12">
      @if($errors->all())
        <div class="alert alert-danger">
          {{ Html::ul($errors->all()) }}
        </div>
      @endif
      <div class="panel panel-default">
        <div class="panel-heading">
            '.$view['action'].'
          <a class="btn btn-sm btn-info" href="{{ URL::to("'.$view['name'].'/create") }}" >
            <i class="glyphicon glyphicon-plus-sign"></i>
            Add '.$view['action'].'
          </a>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
          <table class="table table-striped">
            <thead>
              <tr>';
            foreach ($view['fields'] as $key => $field) {
  $template.='
                <th>'.$field['label'].'</th>';
            }
  $template.='
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($'.str_plural($view['name']).' as $'.$view['name'].')
              <tr>';
            foreach ($view['fields'] as $key => $field) {
  $template.='
                <td>{{ $'.$view['name'].'->'.$field['value'].' }}</td>';
            }
  $template.='
                <td>
                  <a class="btn btn-sm btn-info"
                    href="{{ route(\''.$view['name'].'.edit\', $'.$view['name'].'->id) }}" >
                    <i class="glyphicon glyphicon-edit"></i>
                    Edit
                    </a>
                  <button class="btn btn-sm btn-danger delete-item-link"
                    data-toggle="modal" data-target=".confirm-delete-modal"
                    data-id=\'{{ URL::to("'.$view['name'].'/" . $'.$view['name'].'->id . "/destroy") }}\'>
                    <i class="glyphicon glyphicon-trash"></i>
                    Delete
                  </button>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.panel-body -->
      </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
  </div>';


    }else{
    $template.='
  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          '.$view['action'].'
        </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-lg-12">
                @if($errors->all())
                  <div class="alert alert-danger">
                    {{ Html::ul($errors->all()) }}
                  </div>
                @endif';
            if ($view['method'] == 'PUT') {
                $template.='
                {{ Form::model($'.$view['name'].', [\'url\' => [\''.$view['route'].'\', $'.$view['name'].'->id], \'method\' => \'PUT\']) }}
                    @method(\'PUT\')';

            }else{

                $template.='
                {{ Form::open([\'url\' => \''.$view['route'].'\', \'id\' => \'form-create\']) }}';
            }

                foreach ($view['fields'] as $key => $field) {
                    if ($field['type'] == 'text') {

                    $template.='
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">'.$field['label'].'</label>
                    <div class="col-sm-6">
                      <input class="form-control">
                    </div>    
                  </div>';

                    }elseif($field['type'] == 'text-static'){

                    $template.='
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">'.$field['label'].'</label>
                    <div class="col-sm-6">
                      <p class="form-control-static">email@example.com</p>
                    </div>
                  </div>';

                    }elseif($field['type'] == 'password'){

                    $template.='
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">'.$field['label'].'</label>
                    <div class="col-sm-6">
                      <input class="form-control" type="password">
                    </div>
                  </div>';

                    }elseif($field['type'] == 'file'){

                    $template.='
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">'.$field['label'].'</label>
                    <div class="col-sm-6">
                      <input type="file">
                    </div>
                  </div>';

                    }elseif($field['type'] == 'text-area'){

                    $template.='
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">'.$field['label'].'</label>
                    <div class="col-sm-6">
                      <textarea class="form-control" rows="3"></textarea>
                    </div>
                  </div>';

                    }elseif($field['type'] == 'checkbox'){

                    $template.='
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">'.$field['label'].'</label>
                    <div class="col-sm-6">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" value="'.$field['init'].'">Checkbox 1
                        </label>
                      </div>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" value="'.$field['init'].'">Checkbox 2
                        </label>
                      </div>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" value="'.$field['init'].'">Checkbox 3
                        </label>
                      </div>
                    </div>
                  </div>';

                    }elseif($field['type'] == 'checkbox-inline'){

                    $template.='
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">'.$field['label'].'</label>';

                        foreach ($field['options'] as $option) {
                    $template.='
                    <div class="col-sm-6">
                      <label class="checkbox-inline">
                        <input type="checkbox">'.$option.'
                      </label>
                    </div>';
                        }

                    $template.='
                </div>';

                    }elseif($field['type'] == 'radio-buttons'){

                    $template.='
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">'.$field['label'].'</label>
                  <div class="col-sm-6">
                    <div class="radio">
                      <label>
                        <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>Radio 1
                        </label>
                      </div>
                      <div class="radio">
                      <label>
                        <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">Radio 2
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3">Radio 3
                      </label>
                    </div>
                  </div>
                </div>';

                    }elseif($field['type'] == 'inline-radio-buttons'){

                    $template.='
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">'.$field['label'].'</label>';

                      foreach ($field['options'] as $option) {
                  $template.='
                  <label class="col-sm-2 col-form-label class="radio-inline">
                    <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline1" value="option1" checked>'.$option.'
                  </label>';
                      }


                  $template.='
                  </div>';

                    }elseif($field['type'] == 'select'){

                    $template.='
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">'.$field['label'].'</label>
                    <div class="col-sm-6">
                      <select class="form-control">
                      @foreach($'.str_plural(substr($field['value'], 0, -3)).' as $'.substr($field['value'], 0, -3).')
                        <option
                          value="{{ $'.substr($field['value'], 0, -3).'->id }}"
                          @if($'.substr($field['value'], 0, -3).'->id== old(\''.$field['value'].'\'))
                            selected="selected"
                          @endif>
                          {{$'.substr($field['value'], 0, -3).'->name }}
                        </option>
                      @endforeach
                      </select>
                    </div>
                  </div>';

                    }elseif($field['type'] == 'multiple-select'){

                    $template.='
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">'.$field['label'].'</label>
                    <div class="col-sm-6">
                      <select multiple class="form-control">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                      </select>
                    </div>
                  </div>';

                    }
                }
                $template.='
                <div class="form-group">
                  <a href="{{url(\''.$view['cancel-route'].'\')}}" class="btn btn-sm btn-default">Cancel</a>
                  <button type="submit" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-save"></i>Save</button>
                </div>
              {{ Form::close() }}
            </div>
          </div>
          <!-- /.row (nested) -->
        </div>
        <!-- /.panel-body -->
      </div>
      <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
  </div>';
    }
    $template.='
</div>
<!-- /#page-wrapper -->
@endsection';

    $componentFile = fopen($view['path'], "w") or die("Unable to open file!");
    fwrite($componentFile, $template);
    fclose($componentFile);

      }

    }
}
