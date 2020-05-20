<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use DB;

class SMSSeederGen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'smsseed:gen';

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

$content='
<?php

use Illuminate\Database\Seeder;

use App\Gender;
use App\Assessment;
use App\AssessmentCategory;
use App\Result;
use App\Religion;
use App\Nationality;
use App\Classe;
use App\Content;
use App\Day;
use App\DisciplinaryBooking;
use App\EducationLevel;
use App\FeeType;
use App\IrregularSchoolActivity;
use App\InventoryItem;
use App\NoReturnItemConsumption;
use App\NoReturnItem;
use App\NoReturnItemReception;
use App\Permission;
use App\ReturnItem;
use App\Role;
use App\RegularSchoolActivity;
use App\SchoolCalender;
use App\SchoolFee;
use App\SchoolTeachingHour;
use App\SchoolTimeBlock;
use App\SchoolTimeTable;
use App\Stream;
use App\Student;
use App\StudentRequirement;
use App\SubjectCategory;
use App\Subject;
use App\SubjectTeacher;
use App\TeacherLeaveDay;
use App\TeacherRating;
use App\TeacherSchedule;
use App\TeacherWorkingDay;
use App\TeacherWorkingHour;
use App\User;
use App\VenueBooking;
use App\Venue;

class SampleSchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* users table */
        $systemAdmin= User::create([
            \'name\' => \'Super User\',
            \'username\' => \'admin\',
            \'email\' => \'admin@schmgtsys.local\',
            \'password\' => bcrypt(\'password\'),
        ]);
        $this->command->info(\'super user seeded\');
        Gender::create([\'id\' => 1, \'name\' => \'male\',]);
        Gender::create([\'id\' => 2, \'name\' => \'female\',]);

        Religion::create([\'id\' => 1, \'name\' => \'Catholic\',]);
        Religion::create([\'id\' => 2, \'name\' => \'Anglican\',]);
        Religion::create([\'id\' => 3, \'name\' => \'Moslem\',]);

        Nationality::create([\'name\' => \'Ugandan\',]);
        Nationality::create([\'name\' => \'Kenyan\',]);
        Nationality::create([\'name\' => \'Tanzanian\',]);

        /* classes table */
        $s1Class = Classe::create([\'id\' => 1, \'code\' => \'S1\', \'name\' => \'S1\',]);
        $s2Class = Classe::create([\'id\' => 2, \'code\' => \'S2\', \'name\' => \'S2\',]);
        $s3Class = Classe::create([\'id\' => 3, \'code\' => \'S3\', \'name\' => \'S3\',]);
        $s4Class = Classe::create([\'id\' => 4, \'code\' => \'S4\', \'name\' => \'S4\',]);
        $s5Class = Classe::create([\'id\' => 5, \'code\' => \'S5\', \'name\' => \'S5\',]);
        $s6Class = Classe::create([\'id\' => 6, \'code\' => \'S6\', \'name\' => \'S6\',]);
        $s7Class = Classe::create([\'id\' => 7, \'code\' => \'NONE\', \'name\' => \'NONE\',]); //AN EVIL QUCIK FIX THIS


        $this->command->info(\'classes seeded\');

        EducationLevel::create([
            \'id\' => 1,
            \'name\' => \'Kindergarten\',
            \'code\' => \'non\',
        ]);
        $primaryeducation = EducationLevel::create([
            \'id\' => 2,
            \'name\' => \'Primary Education\',
            \'code\' => \'ple\',
        ]);
        $olevel = EducationLevel::create([
            \'id\' => 3,
            \'name\' => \'O Level\',
            \'code\' => \'uce\',
        ]);
        $alevel = EducationLevel::create([
            \'id\' => 4,
            \'name\' => \'A Level\',
            \'code\' => \'uace\',
        ]);

        $superUser = Role::create([
        \'name\' => \'Super User\',
        ]);
        Role::create([
        \'name\' => \'Director\',
        ]);
        Role::create([
        \'name\' => \'Headmaster\',
        ]);
        Role::create([
        \'name\' => \'Teacher\',
        ]);

        $permissions = [
          [\'name\' => \'manage_users\', \'display_name\' => \'Manage Users\'],
          [\'name\' => \'manage_students\', \'display_name\' => \'Manage Students\'],
          [\'name\' => \'manage_assessments\', \'display_name\' => \'Manage Assessments\'],
          [\'name\' => \'manage_classes\', \'display_name\' => \'Manage Classes\'],
          [\'name\' => \'manage_subjects\', \'display_name\' => \'Manage Subjects\'],
        ];

        foreach ($permissions as $permission) {
          Permission::create($permission);
        }

        $permissions = Permission::all();

        //Assign all permissions to role administrator
        foreach ($permissions as $permission) {
          $superUser->attachPermission($permission);
        }
        //Assign role Administrator to user 1 administrator
        $systemAdmin->attachRole($superUser);

        SubjectCategory::create([\'id\' => 1, \'name\' => \'Arts\',]);
        SubjectCategory::create([\'id\' => 2, \'name\' => \'Sciences\',]);
';

$hSCGradeCodes = DB::connection('mysqlschmgtsys')->table('alevel_grading')->get();

foreach ($hSCGradeCodes as $hSCGradeCode) {
    $points = 0;
    switch ($hSCGradeCode->grade) {
        case 'A':
            $points = 6;
            break;
        case 'B':
            $points = 5;
            break;
        case 'C':
            $points = 4;
            break;
        case 'D':
            $points = 3;
            break;
        case 'E':
            $points = 2;
            break;
        case 'O':
            $points = 1;
            break;
        case 'F':
            $points = 0;
            break;
        default:
            $points = 0;
            break;
    }
$content.='
        $hSCGradeCode'.$hSCGradeCode->id.' = \App\HSCGradeCode::Create([
            \'code\' => \''.$hSCGradeCode->grade_coding.'\',
            \'grade\' => \''.$hSCGradeCode->grade.'\',
            \'points\' => \''.$points.'\',
        ]);
';
}

$streams = DB::connection('mysqlschmgtsys')->table('streams')->get();

foreach ($streams as $stream) {
$content.='
        $stream'.$stream->stream_ID.' = \App\Stream::Create([
            \'name\' => \''.$stream->stream_name.'\',
        ]);
';
}

$assessmentCategories = DB::connection('mysqlschmgtsys')->table('periods')->get();

foreach ($assessmentCategories as $assessmentCategory) {
$content.='
        $assessmentCategory'.$assessmentCategory->period_ID.' = \App\AssessmentCategory::Create([
            \'name\' => \''.$assessmentCategory->period_name.'\',
        ]);
';
}

$assessments = DB::connection('mysqlschmgtsys')->table('terms')->get();

foreach ($assessments as $assessment) {
$content.='
        $assessment'.$assessment->term_ID.' = \App\Assessment::Create([
            \'assessment_category_id\' => $assessmentCategory2->id,
            \'description\' => \''.$assessment->term_name.'\',
            \'start_date\' => \''.$assessment->created_at.'\',
        ]);
';
}

$parents = DB::connection('mysqlschmgtsys')->table('parents')->get();

foreach ($parents as $parent) {
$content.='
        $parent'.$parent->parent_ID.' = \App\Parente::Create([
            \'first_name\' => \''.$parent->pfname.'\',
            \'last_name\' => \''.$parent->plname.'\',
            \'telephone\' => \''.$parent->telephone.'\',
            \'address\' => \''.$parent->address.'\',
            \'occupation\' => \''.$parent->occupation.'\',
            \'relationship\' => \''.$parent->relationship.'\',
            \'created_at\' => \''.$parent->created_at.'\',
        ]);
';
}

$subjects = DB::connection('mysqlschmgtsys')->table('subjects')->get();

foreach ($subjects as $subject) {
$content.='
        $subject'.$subject->subject_ID.' = \App\Subject::Create([
            \'code\' => \''.$subject->subject_code.'\',
            \'name\' => \''.$subject->subject_name.'\',
        ]);
';
}

// generate
/*

student_subject
-student_id
-subject_id

also 
class_subject
- subject_id
- class_id
- compulsory(boolean)
*/


$subjects = DB::connection('mysqlschmgtsys')->table('alevel_subjects')->get();

foreach ($subjects as $subject) {
$content.='
        $subjectALevel'.$subject->subject_ID.' = \App\Subject::Create([
            \'code\' => \''.$subject->subject_code.'\',
            \'name\' => \''.$subject->subject_name.'\',
        ]);
';
}

$papers = DB::connection('mysqlschmgtsys')->table('papers')->get();

foreach ($papers as $paper) {
$content.='
        $paper'.$paper->paper_ID.' = \App\Paper::Create([
            \'code\' => \''.$paper->paper_ID.'\',
            \'name\' => \''.$paper->paper_name.'\',
        ]);
';
}

/*
subjects
-code
-name
-subject_category_id
-education_level_id
*/

$students = DB::connection('mysqlschmgtsys')->table('students')->get();
foreach ($students as $student) {

$gender = (trim($student->gender) == 'Male') ? 1 : 2;
$date = '';
$date .= $student->year_of_birth;
$date .= '-'.str_pad($student->month_of_birth, 2, '0', STR_PAD_LEFT);
$date .= '-'.str_pad($student->day_of_birth, 2, '0', STR_PAD_LEFT);
$date .= ' 00:00:00';
$date = (($date == '0-00-00 00:00:00')||($date == '12-12-12 00:00:00')) ? null : strtotime($date) ;
$date = date('Y-m-d',$date);
$content.='

        $student'.$student->student_ID.' = \App\Student::Create([
            \'first_name\' => \''.$student->fname.'\',
            \'last_name\' => \''.$student->lname.'\',
            \'dob\' => \''.$date.'\',
            \'gender_id\' => \''.$gender.'\',
            \'photo_path\' => \''.'images/'.$student->photo.'\',
            \'class_id\' => $s'.$student->class_ID.'Class->id,
            \'nationality_id\' => \''.$student->nationality_ID.'\',
            \'religion_id\' => \''.$student->religion_ID.'\',
            \'reg_no\' => \''.$student->regNo.'\',
            \'section\' => \''.$student->section.'\',
            \'parent_id\' => $parent'.$student->parent_ID.'->id,
            \'created_at\' => \''.$student->created_at.'\',
            \'stream_id\' => $stream'.$student->stream_ID.'->id,
        ]);
';

}

$combinations = DB::connection('mysqlschmgtsys')->table('combinations')->get();

foreach ($combinations as $combination) {
$content.='
        $combination'.$combination->combination_ID.' = \App\Combination::Create([
            \'name\' => \''.$combination->combination_name.'\',
        ]);
';
}

// process the paper_id
$results = DB::connection('mysqlschmgtsys')->table('std_marks')->get();

foreach ($results as $result) {
$content.='
        \App\StudentScore::Create([
            \'assesment_id\' => $assessment'.$result->term_ID.'->id,
            \'student_id\' => $student'.$result->student_ID.'->id,
            \'subject_id\' => $subject'.$result->subject_ID.'->id,
            \'percentage\' => \''.$result->marks.'\',
        ]);
';
}



$results = DB::connection('mysqlschmgtsys')->table('std_marks_alevel')->get();

foreach ($results as $result) {
$content.='
        \App\StudentScore::Create([
            \'assesment_id\' => $assessment'.$result->term_ID.'->id,
            \'student_id\' => $student'.$result->student_ID.'->id,
            \'paper_id\' => $paper'.$result->paper_ID.'->id,
            \'subject_id\' => $subject'.$result->subject_ID.'->id,
            \'percentage\' => \''.$result->marks.'\',
        ]);
';
}

/*
this changes to student_scores
process the paper_id
*/
$results = DB::connection('mysqlschmgtsys')->table('std_marks_middle')->get();
foreach ($results as $result) {
$content.='
        \App\StudentScore::Create([
            \'assesment_id\' => $assessment'.$result->term_ID.'->id,
            \'student_id\' => $student'.$result->student_ID.'->id,
            \'subject_id\' => $subject'.$result->subject_ID.'->id,
            \'paper_id\' => $paper'.$result->subject_ID.'->id,
            \'percentage\' => \''.$result->marks.'\',
        ]);
';
}

$content.='
    }
}
';

        $seederFile = fopen("/var/www/schmgtsys/database/seeds/SampleSchoolSeeder.php", "w") or die("Unable to open file!");
        fwrite($seederFile, $content);
        fclose($seederFile);

    }
}
