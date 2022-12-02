<?php 
$example = "example_input.txt";
$puzzle = "puzzle_input.txt";

$filename = $puzzle;

$input = trim(file_get_contents($filename));

$lines = explode("\n",$input);


$count = 0;
foreach($lines as $line){
  list($pos1, $pos2, $letter, $password) = parseString($line);
  if( isValidPassword($pos1, $pos2, $letter, $password) ){
    echo $password.PHP_EOL;
    $count++;
  }
}
echo "There are {$count} valid passwords".PHP_EOL;

function isValidPassword($pos1, $pos2, $letter, $password){
  $chars = str_split($password);
  $pos1--;
  $pos2--;

  $count = 0;
  if($chars[$pos1] == $letter) $count++;
  if($chars[$pos2] == $letter) $count++;
  
  return ($count == 1);
}

function parseString($s){
  $result = [];
  $args = explode(" ",$s);
  $result = explode("-",$args[0]);
  $result[] = substr($args[1],0,-1);
  $result[] = $args[2];
  return $result;
}