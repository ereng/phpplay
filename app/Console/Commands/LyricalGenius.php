<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use DB;

class LyricalGenius extends Command
{
  protected $signature = 'flow';

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

    $file = fopen("/var/www/ryhmengin/flow.txt", "r") or die("Unable to open file!");

    // if there is cin the file
    if(filesize("/var/www/ryhmengin/flow.txt") > 0)
      $text =  fread($file,filesize("/var/www/ryhmengin/flow.txt"));
    fclose($file);

// dd($text);
    $text = strtolower($text);

    // leave only spaces
    $text = preg_replace("/[^\w\s]+/", "", $text);

    // replace multiple spaces with one
    $text = preg_replace('!\s+!', ' ', $text);

// dd($text);
    $vocabulary = explode(" ", $text);

    $vocabularyHuddledUp = [];

    $vocabulary = array_unique($vocabulary);

    $this->findRhymes($vocabulary,$vocabularyHuddledUp);
    // TODO: TO SEND THINGS BACK ALL THE DECISION FOR ALL CALLS TO FUNCTIONS WILL HAVE TO BE BROUGHT BACK HERE
    // $response = $this->findRhymes($vocabulary,$vocabularyHuddledUp);
    // return $response;
  }

  public function findRhymes($vocabulary, $vocabularyHuddledUp)
  {

    // if vocabulary is not empty
    if (!empty($vocabulary)) {

      // pick word at random from vocabulary
      $randomVocabularyKey = array_rand($vocabulary);
      $randomVocabularyWord = $vocabulary[$randomVocabularyKey];
  
      // get raw rhymes from C++ rhyme engine
      $rhymesText = shell_exec("cd /var/www/ryhmengin && ./poet ".$randomVocabularyWord);

      // if there is content that rhymes
      if($rhymesText != null){

        $rhymesArray = explode("\n", $rhymesText);
        $this->assign($vocabulary,$vocabularyHuddledUp,$randomVocabularyKey,$rhymesArray);
      }else{

        // dont huddle up, just remove what has no ryhmes
        unset($vocabulary[$randomVocabularyKey]);
        $this->findRhymes($vocabulary,$vocabularyHuddledUp);
      }
    }else{
      $response = exec("cd /var/www/ryhmengin && echo \"".implode(" ", $vocabularyHuddledUp)."\" > huddling.txt && subl huddling.txt");
    }
  }

  public function assign($vocabulary,$vocabularyHuddledUp,$randomVocabularyKey,$rhymesArray)
  {
      $nothingFound = true;
      // of all the words returned, check which ones belong to vocabulary
      foreach ($rhymesArray as $string) {

        $word = explode(" ", $string);

        // word is in vocabulary huddle it Up{cluster rhyming words together}
        if (in_array($word[0], $vocabulary) && $word[0] != '') {

          $nothingFound = false;
          // huddle up even if already huddled up
          array_push($vocabularyHuddledUp, $word[0]);
          unset($vocabulary[$randomVocabularyKey]);
        }else{

          // still unset anyway may be that empty thing not sure
          unset($vocabulary[$randomVocabularyKey]);
        }
      }

      // nothing found that ryhmes
      if ($nothingFound) {

        // dont huddle up, just remove
        unset($vocabulary[$randomVocabularyKey]);
      }
    $this->findRhymes($vocabulary,$vocabularyHuddledUp);
  }
}
