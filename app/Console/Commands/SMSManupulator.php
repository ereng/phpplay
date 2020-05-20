<?php

namespace App\Console\Commands;

use DB;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use GuzzleHttp\Exception\ClientException;

class SMSManupulator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms {verb} {content}';

    // php artisan sms post student
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
      try {

        if ($this->argument('verb') == 'post') {

          if ($this->argument('content') == 'student') {
            $postParent = $this->postContent(
              $this->getContent('parent'),
              'http://schmgtsys.local/api/parent');
// dd($postParent);
            $local = DB::table('names')->inRandomOrder()->first();
            // $name = strpos($local->name, ' ');\
            $faker = \Faker\Factory::create();
            $names = explode(' ', $local->name,2);
            $student = [
              'first_name' => $names[1],
              'last_name' => $names[0],
              'stream_id' => '1',//pick at random
              'class_id' => '1',//fn(stream_id)
              'religion_id' => '1',//pick at random
              'nationality_id' => '1',//pick at random
              'parent_id' => $postParent->id,
              'dob' => '2005-09-26',
              'gender_id' => ($local->gender == 'male') ? 1 : 2 ,
              'photo_path' => $faker->swiftBicNumber.'.png',
              'reg_no' => $faker->swiftBicNumber,
            ];

            $postStudent = $this->postContent($student,'http://schmgtsys.local/api/student');

            echo "student posted";
            dd($postStudent);
          }elseif ($this->argument('content') == 'circumstance') {
            $postCircumstance = $this->postContent();
            \Log::info($postCircumstance->getBody()->getContents());
          }
        }
      } catch (\GuzzleHttp\Exception\ClientException $e) {
        // status 401
        echo "Token Expired\n";
        $clientLogin = new Client();
        // send results for individual tests for starters
        $loginResponse = $clientLogin->request('POST', 'http://schmgtsys.local/api/login', [
          'headers' => [
            'Accept' => 'application/json',
            'Content-type' => 'application/json'
          ],
          'json' => [
            'username' => 'admin@schmgtsys.local',
            'password' => 'password'
          ],
        ]);
      if ($loginResponse->getStatusCode() == 200) {
        echo "Logged In\n";
        $accessToken = json_decode($loginResponse->getBody()->getContents())->token;
        \App\Models\UserAccess::where('email','admin@schmgtsys.local')->update(['access_token' => $accessToken]);
      }else{
        echo "loggin failed";
      }
    }catch(Exception $e){
      echo "I have no clue what the problem is!";
    }
  }

  public function postContent($content,$url)
  {
    $accessToken = \App\Models\UserAccess::where('email','admin@schmgtsys.local')->first()->access_token;

    $client = new Client();

    $response = $client->request('POST', $url, [
      'headers' => [
        'Accept' => 'application/json',
        'Content-type' => 'application/json',
        'Authorization' => 'Bearer '.$accessToken,
      ],
      'json' => $content,
    ]);
    echo "content posted\n";
    return json_decode($response->getBody()->getContents());
  }

  public function getContent($contentType)
  {
    $faker = \Faker\Factory::create();
    $content = [];
    if ($contentType == 'parent') {
      // $person = factory(\App\Models\Person::class)->create();
      // $local = DB::table('local_names')->inRandomOrder()->first();
      // factory(App\Models\Person::class)->create();

      $occupations = [
        'Engineer',
        'Doctor',
        'Farmer',
        'Proleteriat',
        'Cool Guy',
        'Musician',
        'Lawyer',
        'Accountant',
        'Brick Layer',
        'Soldier',
        'Police',
        'Civil Servant',
        'Hunter'
      ];

      $relationships = [
        'Son',
        'Brother',
        'Father',
        'Grand Father',
        'Great Grand Father'
      ];

      $genders = [
        'male',
        'female'
      ];

      $gender = $genders[array_rand($genders)];
      
      $content = [
        'first_name' => ($gender=='male') ? $faker->firstNameMale : $faker->firstNameFemale,
        'last_name' => $faker->lastName,//$faker->lastName($gender),
        'telecom' => $faker->e164PhoneNumber,
        'gender' => $gender,//$gender,
        'address' => $faker->address,
        'occupation' => $occupations[array_rand($occupations)],
        'relationship' => $relationships[array_rand($relationships)],
      ];

    }elseif ($contentType == 'combination') {
      $content = [
        'combination_id' => '',
      ];

    }elseif ($contentType == 'assessmentStatus') {
      $content = [
        'name' => '',// completed
      ];

    }
    return $content;
  }

  public function takeStudentScores($studentId)
  {
        $studentScore = [
          'assessment_id' => '',
          'student_id' => '',
          'paper_id' => '',
          'subject_id' => '',
          'percentage' => '',
        ];
  }

  public function gradeStudent($studentId)
  {
    if ($level == 'a') {
      $hscStudentGrade = [
        'assessment_id' => '',
        'student_id' => '',
        'combination_id' => '',
        'hsc_grade_code_id' => '',
      ];

    }elseif ($level == '0') {
      $sscStudentGrade = [
        'assessment_id' => '',
        'student_id' => '',
        'subject_id' => '',
        'score_grade_id' => '',
      ];
    }
  }
}
