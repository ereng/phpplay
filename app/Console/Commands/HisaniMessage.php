<?php

namespace App\Console\Commands;

use DB;
use Uuid;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class HisaniMessage extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'hisani:message';

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
      // status 200
      $sendMessage = $this->sendMessage();
      dd($sendMessage->getBody()->getContents());
    } catch (\GuzzleHttp\Exception\ClientException $e) {
      // status 401
      echo "Token Expired\n";
      $clientLogin = new Client();
      // send results for individual tests for starters
      $loginResponse = $clientLogin->request('POST', 'http://ihsani.local/api/login', [
        'headers' => [
          'Accept' => 'application/json',
          'Content-type' => 'application/json'
        ],
        'json' => [
          'username' => 'admin@ihsani.dev',
          'password' => 'password'
        ],
      ]);
      if ($loginResponse->getStatusCode() == 200) {
        echo "LoggedIn\n";
        $accessToken = json_decode($loginResponse->getBody()->getContents())->token;
        \App\Models\UserAccess::where('email','admin@ihsani.dev')->update(['access_token' => $accessToken]);

        $sendMessage = $this->sendMessage();

        if ($sendMessage->getStatusCode() == 200) {
          dd($sendMessage->getBody()->getContents());
        }else{
          dd('real problem up in here');

        }
      }else{
        dd('real problem up in here');

      }
    }catch(Exception $e){
      echo "AGH!";
    }
  }

  public function sendMessage()
  {
    $accessToken = \App\Models\UserAccess::where('email','admin@ihsani.dev')->first()->access_token;

    $cleint = new Client();


    $data = [
      'ticket_id'     => 1,
      'content'     => 'Sample Message',
    ];

    $sendMessage = $cleint->request('POST', 'http://ihsani.local/api/message', [
      'headers' => [
        'Accept' => 'application/json',
        'Content-type' => 'application/json',
        'Authorization' => 'Bearer '.$accessToken,
      ],
      'json' => $data,
    ]);

    return $sendMessage;
  }
}
