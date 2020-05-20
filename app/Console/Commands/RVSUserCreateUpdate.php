<?php
namespace App\Console\Commands;
use DB;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
/*
 *use passport not jwt else get the error
 *The resource owner or authorization server denied the request.
 *{"exception":"[object] ( League\\OAuth2\\Server\\Exception\\OAuthServerException
 */
class RVSUserCreateUpdate extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
             /** action(s) **\
php artisan rvs:users
             \**            **/         
  protected $signature = 'rvs:users';
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
    $users = [
      [
        'name' => 'Benjamin Owenda',
        'username' => 'benja',
        // 'password' => 'dopeboy1',
        // 'password' => 'password',
      ],
      [
        'name' => 'George Muchiri',
        'username' => 'joges',
        // 'password' => 'dopeboy2',
        // 'password' => 'password',
      ],
      [
        'name' => 'Andrew Ater',
        'username' => 'ater',
        // 'password' => 'dopeboy3',
        // 'password' => 'password',
      ],
    ];
    try {
      foreach ($users as $user) {
        echo $user['name'];
        echo "\n";
        $userQuery = '?name='.$user['name'];
        $userQuery .= '&username='.$user['username'];
        // $userQuery .= '&password='.$user['password'];
        $post = $this->post($userQuery);
      }
    } catch (\GuzzleHttp\Exception\ClientException $e) {
dd($e);
      // status 401
      echo "Token Expired\n";
      $clientLogin = new Client();

      $loginResponse = $clientLogin->request('POST', env('RVS_LOGIN_URL', 'http://riverside.local/api/login'), [
        'headers' => [
          'Accept' => 'application/json',
          'Content-type' => 'application/json'
      ],
        'json' => [
          'username' => 'admin@riversideresidence.org',
          'email' => 'admin@riversideresidence.org',
          'password' => 'password'
      ],
      ]);
      if ($loginResponse->getStatusCode() == 200) {
        $accessToken = json_decode($loginResponse->getBody()->getContents())->token;
        echo $accessToken."\n";
        \App\ThirdPartyApp::where('email','admin@riversideresidence.org')->update(['access_token' => $accessToken]);
      }else{
        dd('real problem up in here');
      }
    }
  }
  public function post($user){

    $accessToken = \App\ThirdPartyApp::where('email','admin@riversideresidence.org')->first()->access_token;
    $client = new Client();
    $response = $client->request('GET', env('RVS_USER_STORE_URL', 'http://riverside.local/api/rvspredict/user/edit'.$user), [
      'headers' => [
        'Accept' => 'application/json',
        'Content-type' => 'application/json',
        'Authorization' => 'Bearer '.$accessToken,
      ],
    ]);
    return $response;
  }
}
