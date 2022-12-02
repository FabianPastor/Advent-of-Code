<?php 
$example       = "example_input.txt";
$puzzle        = "puzzle_input.txt";

$filename = $puzzle;

$input = trim(file_get_contents($filename));

$numbers = array_map("trim",explode(",", $input));
$n = count($numbers);
$spoken = [];

$resultFinal = [0,3,6,0,3,3,1,0,4,0,"X"];


$i = 0;
$number = 0;

$playing = true;
$result = [];
while($playing){
  
  $number = elfSays($i, $number);
  echo "$i, $number".PHP_EOL;
  $result[] = $number;
  $spoken[$number][1] = $spoken[$number][0] ?? null;
  $spoken[$number][0] = $i+1;
  
  
  // if($i >= 10){
  //   $playing = false;
  // }
  if(($i+1) == 30000000){
    $playing = false;
  }
  
  $i++;
}
echo "$number\n";


function elfSays($i, $l){
  global $numbers, $n, $spoken;
  
  if($i < $n){
    return $numbers[$i];
  }
  
  if(!isset($spoken[$l]) || is_null($spoken[$l][1])){
    return 0;
  }
  //echo "$i - {$spoken[$l][1]} ".PHP_EOL;
  return ($i - $spoken[$l][1]);
}