<?php 
$example = "example_input.txt";
$puzzle = "puzzle_input.txt";

$filename = $puzzle;

$input = trim(file_get_contents($filename));


$group_responses = explode(PHP_EOL.PHP_EOL, $input);

$sum = 0;
foreach($group_responses as $i => $responses_str){
  $votation = new Votation($responses_str);
  echo "Group {$i}".PHP_EOL;
  echo " Total Voters: ".$votation->getNumberVoters().PHP_EOL;
  echo " Total Answers: ".$votation->countYesVotes().PHP_EOL;
  $sum += $votation->countYesVotes();
  echo PHP_EOL;
}
echo "Total number of answers that got voted Yes: {$sum}".PHP_EOL;


class Votation{
  public $answers;
  
  public function __construct($responses_str){
    $responses = explode(PHP_EOL, $responses_str);
    $res = [];
    foreach($responses as $ans){
      $ans = str_split($ans);
      foreach($ans as $a){
        if(!isset($res[$a]))
          $res[$a] = 0;
        $res[$a]++;
      }
    }
    $this->answers = $res;
  }
  public function getNumberVoters(){
    return array_sum($this->answers);
  }
  public function countYesVotes(){
    return count($this->answers);
  }
}