<?php
namespace App\Console\Commands;
use DB;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class RVSUserTokens extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
php artisan rvs:tokens
   */
  protected $signature = 'rvs:tokens';
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
    $users = $this->users();

    //save each new user
    foreach ($users as $user) {
      if (\App\ThirdPartyApp::where('email',$user->email)->count()>0||
          \App\ThirdPartyApp::where('username',$user->username)->count()>0) {
      }else{
        $savedUser = \App\ThirdPartyApp::create([
          'id' => (string) Str::uuid(),
          'email' => ($user->email) ? $user->email : Str::uuid(7),
          'name' => $user->name,
          'username' => $user->username,
          'password' =>  bcrypt('password'),
        ]);
        echo "\n";
        echo "created ".$savedUser->name;
      }
    }

    $savedUsers = \App\ThirdPartyApp::all();
    try {
      // each new user login and make predictions
      foreach ($savedUsers as $savedUser) {

// dd($savedUser);
        $post = $this->login($savedUser);
      }
    } catch (\GuzzleHttp\Exception\ClientException $e) {
      dd($e->getMessage());
    }
  }
  public function login($user){

    echo "Get Token for ".$user->name."\n";
    $clientLogin = new Client();
    // send results for individual tests for starters
    $loginResponse = $clientLogin->request('POST', env('RVS_LOGIN_URL', 'http://riverside.local/api/login'), [
      'headers' => [
        'Accept' => 'application/json',
        'Content-type' => 'application/json'
      ],
      'json' => [
        'username' => $user->username,
        // 'email' => $user->email,
        'password' => 'password'
      ],
    ]);
    if ($loginResponse->getStatusCode() == 200) {
      $accessToken = json_decode($loginResponse->getBody()->getContents())->access_token;
      echo $accessToken."\n";
      \App\ThirdPartyApp::where('username',$user->username)->update(['access_token' => $accessToken]);

    }else{
      dd('real problem up in here');
    }
  }

  public function users(){
    $accessToken = \App\ThirdPartyApp::where('email','admin@riversideresidence.org')->first()->access_token;
    $client = new Client();

    $response = $client->request('GET', env('RVS_GAMER_GET', 'http://riverside.local/api/rvspredict/user'), [
      'headers' => [
        'Accept' => 'application/json',
        'Content-type' => 'application/json',
        'Authorization' => 'Bearer '.$accessToken,
      ],
    ]);
    return json_decode($response->getBody()->getContents());
  }
}
