<?php
namespace App\Console\Commands;

use DB;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class ML4AfrikaLogin extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */

  protected $signature = 'ml4afrika:login';

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
    $clientLogin = new Client();

    $loginResponse = $clientLogin->request('POST', 'http://192.168.134.53:8080/mhealth4afrika/uaa/oauth/token', [
        'headers' => [
            'Authorization' => 'Basic '.base64_encode('ilab:87047e052-e35a-91e4-eaa4-43be9615eb8'),
            'Accept' => 'application/json',
            'Content-type' => 'application/x-www-form-urlencoded',
        ],
        'form_params' => [
            'username' => 'admin',
            'password' => 'district',
            'grant_type' => 'password',
         ],
    ]);

       if ($loginResponse->getStatusCode() == 200) {
echo "\n";
echo 'got token !!!!!';
echo "\n";
echo $accessToken;
echo "\n";
            $accessToken = json_decode($loginResponse->getBody()->getContents())->access_token;
            \App\ThirdPartyApp::where('email','ml4afrika@play.dev')->update(['access_token' => $accessToken]);

        }
  }
}
