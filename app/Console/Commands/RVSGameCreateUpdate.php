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

class RVSGameCreateUpdate extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
             /** action(s) **\
              |    seed     |
              | getmappings |
              | getesttypes |
              |    store    |
              |   destroy   |
              php artisan rvs:games {score}
             \**            **/         
  protected $signature = 'rvs:games {score}';
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
    $games = [
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-21 22:00:00',
        'description' => 'Match 1',
        'home_team' => 'Egypt',
        'away_team' => 'Zimbabwe',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-22 16:30:00',
        'description' => 'Match 2',
        'home_team' => 'DR Congo',
        'away_team' => 'Uganda',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-26 19:00:00',
        'description' => 'Match 14',
        'home_team' => 'Uganda',
        'away_team' => 'Zimbabwe',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-26 22:00:00',
        'description' => 'Match 13',
        'home_team' => 'Egypt',
        'away_team' => 'DR Congo',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-30 21:00:00',
        'description' => 'Match 25',
        'home_team' => 'Uganda',
        'away_team' => 'Egypt',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-30 21:00:00',
        'description' => 'Match 26',
        'home_team' => 'Zimbabwe',
        'away_team' => 'DR Congo',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-22 19:00:00',
        'description' => 'Match 3',
        'home_team' => 'Nigeria',
        'away_team' => 'Burundi',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-22 22:00:00',
        'description' => 'Match 4',
        'home_team' => 'Guinea',
        'away_team' => 'Madagascar',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-26 16:30:00',
        'description' => 'Match 15',
        'home_team' => 'Nigeria',
        'away_team' => 'Guinea',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-27 16:30:00',
        'description' => 'Match 16',
        'home_team' => 'Madagascar',
        'away_team' => 'Burundi',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-30 18:00:00',
        'description' => 'Match 27',
        'home_team' => 'Madagascar',
        'away_team' => 'Nigeria',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-30 18:00:00',
        'description' => 'Match 28',
        'home_team' => 'Burundi',
        'away_team' => 'Guinea',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-23 19:00:00',
        'description' => 'Match 5',
        'home_team' => 'Senegal',
        'away_team' => 'Tanzania',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-23 22:00:00',
        'description' => 'Match 6',
        'home_team' => 'Algeria',
        'away_team' => 'Kenya',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-27 19:00:00',
        'description' => 'Match 17',
        'home_team' => 'Senegal',
        'away_team' => 'Algeria',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-27 22:00:00',
        'description' => 'Match 18',
        'home_team' => 'Kenya',
        'away_team' => 'Tanzania',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-07-01 21:00:00',
        'description' => 'Match 29',
        'home_team' => 'Kenya',
        'away_team' => 'Senegal',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-07-01 21:00:00',
        'description' => 'Match 30',
        'home_team' => 'Tanzania',
        'away_team' => 'Algeria',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-23 16:30:00',
        'description' => 'Match 7',
        'home_team' => 'Morocco',
        'away_team' => 'Namibia',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-24 16:30:00',
        'description' => 'Match 8',
        'home_team' => 'Ivory Coast',
        'away_team' => 'South Africa',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-28 19:00:00',
        'description' => 'Match 19',
        'home_team' => 'Morocco',
        'away_team' => 'Ivory Coast',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-28 22:00:00',
        'description' => 'Match 20',
        'home_team' => 'South Africa',
        'away_team' => 'Namibia',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-07-01 18:00:00',
        'description' => 'Match 31',
        'home_team' => 'South Africa',
        'away_team' => 'Morocco',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-07-01 18:00:00',
        'description' => 'Match 32',
        'home_team' => 'Namibia',
        'away_team' => 'Ivory Coast',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-24 19:00:00',
        'description' => 'Match 9',
        'home_team' => 'Tunisia',
        'away_team' => 'Angola',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-24 22:00:00',
        'description' => 'Match 10',
        'home_team' => 'Mali',
        'away_team' => 'Mauritania',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-28 16:30:00',
        'description' => 'Match 21',
        'home_team' => 'Tunisia',
        'away_team' => 'Mali',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-29 16:30:00',
        'description' => 'Match 22',
        'home_team' => 'Mauritania',
        'away_team' => 'Angola',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-07-02 21:00:00',
        'description' => 'Match 33',
        'home_team' => 'Mauritania',
        'away_team' => 'Tunisia',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-07-02 21:00:00',
        'description' => 'Match 34',
        'home_team' => 'Angola',
        'away_team' => 'Mali',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-25 19:00:00',
        'description' => 'Match 11',
        'home_team' => 'Cameroon',
        'away_team' => 'Guinea-Bissau',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-25 22:00:00',
        'description' => 'Match 12',
        'home_team' => 'Ghana',
        'away_team' => 'Benin',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-29 19:00:00',
        'description' => 'Match 23',
        'home_team' => 'Cameroon',
        'away_team' => 'Ghana',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-06-29 22:00:00',
        'description' => 'Match 24',
        'home_team' => 'Benin',
        'away_team' => 'Guinea-Bissau',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-07-02 18:00:00',
        'description' => 'Match 35',
        'home_team' => 'Benin',
        'away_team' => 'Cameroon',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-07-02 18:00:00',
        'description' => 'Match 36',
        'home_team' => 'Guinea-Bissau',
        'away_team' => 'Ghana',
      ],
      // -------------------------------------------//
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-07-05 18:00:00',
        'description' => 'Match 41',
        'home_team' => 'Winner Group D',
        'away_team' => '3rd Group B/E/F',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-07-05 21:00:00',
        'description' => 'Match 38',
        'home_team' => 'Runner-up Group A',
        'away_team' => 'Runner-up Group C',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-07-06 19:00:00',
        'description' => 'Match 42',
        'home_team' => 'Runner-up Group B',
        'away_team' => 'Runner-up Group F',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-07-06 21:00:00',
        'description' => 'Match 39',
        'home_team' => 'Winner Group A',
        'away_team' => '3rd Group C/D/E',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-07-07 18:00:00',
        'description' => 'Match 37',
        'home_team' => 'Winner Group B',
        'away_team' => '3rd Group A/C/D',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-07-07 21:00:00',
        'description' => 'Match 40',
        'home_team' => 'Winner Group C',
        'away_team' => '3rd Group A/B/F',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-07-08 19:00:00',
        'description' => 'Match 43',
        'home_team' => 'Winner Group E',
        'away_team' => 'Runner-up Group D',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-07-08 21:00:00',
        'description' => 'Match 44',
        'home_team' => 'Winner Group F',
        'away_team' => 'Runner-up Group E',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-07-10 19:00:00',
        'description' => 'Match 45',
        'home_team' => 'Winner Match 38',
        'away_team' => 'Winner Match 41',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-07-10 21:00:00',
        'description' => 'Match 48',
        'home_team' => 'Winner Match 42',
        'away_team' => 'Winner Match 39',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-07-11 19:00:00',
        'description' => 'Match 47',
        'home_team' => 'Winner Match 43',
        'away_team' => 'Winner Match 40',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-07-11 21:00:00',
        'description' => 'Match 46',
        'home_team' => 'Winner Match 37',
        'away_team' => 'Winner Match 44',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-07-14 18:00:00',
        'description' => 'Match 49',
        'home_team' => 'Winner Match 45',
        'away_team' => 'Winner Match 46',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-07-14 21:00:00',
        'description' => 'Match 50',
        'home_team' => 'Winner Match 47',
        'away_team' => 'Winner Match 48',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-07-17 21:00:00',
        'description' => 'Match 51',
        'home_team' => 'Loser Match 49',
        'away_team' => 'Loser Match 50',
      ],
      [
        'tournament' => 'Africa Cup of Nations',
        'start_time' => '2019-07-19 21:00:00',
        'description' => 'Match 52',
        'home_team' => 'Winner Match 49',
        'away_team' => 'Winner Match 50',
      ],
    ];
    try {
      foreach ($games as $game) {
        if ($this->argument('score') == 'score') {
          $gameScore = [];
          $gameScore['tournament'] = $game['tournament'];
          $gameScore['start_time'] = $game['start_time'];
          $gameScore['description'] = $game['description'];
          $gameScore['home_team'] = $game['home_team'];
          $gameScore['away_team'] = $game['away_team'];
          $gameScore['home_team_score'] = array_rand([0,1,2,3,4,5,6]);
          $gameScore['away_team_score'] = array_rand([0,1,2,3,4,5,6]);
          $post = $this->post($gameScore);
        }else{
          $post = $this->post($game);
        }

        echo $game['description'];
        echo "\n";
      }
    } catch (\GuzzleHttp\Exception\ClientException $e) {
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
  public function post($game){

    $accessToken = \App\ThirdPartyApp::where('email','admin@riversideresidence.org')->first()->access_token;
    $client = new Client();
    $game;

    $response = $client->request('POST', env('RVS_GAME_BULK_STORE_URL', 'http://riverside.local/api/rvspredict/updategamebynames'), [
      'headers' => [
        'Accept' => 'application/json',
        'Content-type' => 'application/json',
        'Authorization' => 'Bearer '.$accessToken,
      ],
      'json' => $game,
    ]);
    return $response;
  }

}
