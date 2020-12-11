<?php 
$example = "example_input.txt";
$puzzle = "puzzle_input.txt";

$filename = $puzzle;

$input = trim(file_get_contents($filename));


$group_responses = explode(PHP_EOL.PHP_EOL, $input);

$sum = 0;
foreach($group_responses as $i => $responses_str){
  $votation = new Votation($responses_str);
  $votation->printJson();
  $answers = $votation->getAnswersVotedByEveryone();
  echo "Group {$i}".PHP_EOL;
  echo " Total Voters: ".$votation->getNumberVoters().PHP_EOL;
  echo " Total Answers: ".$votation->getNumberAnswers().PHP_EOL;
  echo " Total Answers Voted by All Voters: {$answers}".PHP_EOL;
  
  $sum += $answers;
  echo PHP_EOL;
}
echo "Total number of answers that got voted Yes: {$sum}".PHP_EOL;


class Votation{
  private $answers;
  private $voters = 0;
  
  public function __construct($responses_str){
    $responses = explode(PHP_EOL, $responses_str);
    $res = [];
    foreach($responses as $ans){
      $this->voters++;
      $ans = str_split($ans);
      foreach($ans as $a){
        if(!isset($res[$a]))
          $res[$a] = 0;
        $res[$a]++;
      }
    }
    $this->answers = $res;
  }
  public function getNumberAnswers(){
    return count($this->answers);
  }
  public function getNumberVoters(){
    return $this->voters;
  }
  
  public function getAnswersVotedByEveryone(){
    $totalVoters = $this->getNumberVoters();
    $sum = 0;
    foreach($this->answers as $ans){
      if($ans == $totalVoters) 
        $sum++;
    }
    return $sum;
  }
  public function printJson($flags = null){
    echo json_encode($this->answers, $flags).PHP_EOL;
  }
}