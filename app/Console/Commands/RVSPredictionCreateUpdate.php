<?php
namespace App\Console\Commands;
use DB;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
/*
 *use passport not jwt else get the error
 *The resource owner or authorization server denied the request.
 *{"exception":"[object] ( League\\OAuth2\\Server\\Exception\\OAuthServerException
 */

class RVSPredictionCreateUpdate extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
php artisan rvs:predictions
   */
  protected $signature = 'rvs:predictions';
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
    // get users
    $users = $this->users();
    $games = $this->games();

    //save each new user
    foreach ($users as $user) {
      try {
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

        $savedUsers = \App\ThirdPartyApp::all();
        // each new user login and make predictions
        foreach ($savedUsers as $savedUser) {
          $post = $this->makePredictions($games,$savedUser);
        }
      } catch (\GuzzleHttp\Exception\ClientException $e) {

        echo $e->getMessage()."\n";
        // status 401
        echo "Token Expired\n";
        $clientLogin = new Client();
        // send results for individual tests for starters
        $loginResponse = $clientLogin->request('POST', env('RVS_LOGIN_URL', 'http://riverside.local/api/login'), [
          'headers' => [
            'Accept' => 'application/json',
            'Content-type' => 'application/json'
          ],
          'json' => [
            'username' => $user->username,
            'email' => $user->email,
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
    }
  }
  public function makePredictions($games,$user){

    $accessToken = \App\ThirdPartyApp::where('username',$user->username)->first()->access_token;
    $client = new Client();

    foreach ($games as $game) {

      $predictionQuery = $game->id;
      $predictionQuery .= '/'.array_rand([0,1,2,3,4,5]);//homeScore
      $predictionQuery .= '/'.array_rand([0,1,2,3,4,5]);//awayScore

      $response = $client->request('GET', env('RVS_PREDICT_URL', 'http://riverside.local/api/rvspredict/prediction/'.$predictionQuery), [
        'headers' => [
          'Accept' => 'application/json',
          'Content-type' => 'application/json',
          'Authorization' => 'Bearer '.$accessToken,
        ],
      ]);
    }
    return ['success'];
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

  public function games(){

    $accessToken = \App\ThirdPartyApp::where('email','admin@riversideresidence.org')->first()->access_token;
    $client = new Client();

    $response = $client->request('GET', env('RVS_GAMES_GET', 'http://riverside.local/api/rvspredict/game'), [
      'headers' => [
        'Accept' => 'application/json',
        'Content-type' => 'application/json',
        'Authorization' => 'Bearer '.$accessToken,
      ],
    ]);
    return json_decode($response->getBody()->getContents());
  }
}
