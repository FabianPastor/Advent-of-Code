<?php 
$example = "example_input.txt";
$puzzle = "puzzle_input.txt";

$filename = $puzzle;

$input = trim(file_get_contents($filename));

$lines = explode("\n",$input);


$count = 0;
foreach($lines as $line){
  list($min, $max, $letter, $password) = parseString($line);
  if( isValidPassword($min, $max, $letter, $password) ){
    //echo $password.PHP_EOL;
    $count++;
  }
}
echo "There are {$count} valid passwords".PHP_EOL;

function isValidPassword($min, $max, $letter, $password){
  $count = 0;
  $chars = str_split($password);
  
  foreach($chars as $char){
    if($char == $letter) $count++;
  }
  if($count >= $min && $count <= $max)
    return true;
  return false;
}

function parseString($s){
  $result = [];
  $args = explode(" ",$s);
  $result = explode("-",$args[0]);
  $result[] = substr($args[1],0,-1);
  $result[] = $args[2];
  return $result;
}