<?php 
$example = "example_input.txt";
$puzzle = "puzzle_input.txt";

$filename = $puzzle;

$input = trim(file_get_contents($filename));

$numbers = array_map("trim",explode(PHP_EOL,$input));



$preambleSize = 25;



$preamble = [];
foreach($numbers as $i => $num){
  //echo "Number $num checked".PHP_EOL;
  if(count($preamble)<$preambleSize){
    //echo "Added number to the preamble".PHP_EOL;
    $preamble[] = $num;
  }else{
    if(checkValid($num,$preamble)){
      //echo "$num is valid;".PHP_EOL;
    }else{
      echo "$num is NOT valid;".PHP_EOL;
    }
    $preamble[] = $num;
    $preamble = array_slice ($preamble, -$preambleSize , $preambleSize);
    //echo json_encode($preamble).PHP_EOL;
  }
}


function checkValid($num, $preamble){
  foreach($preamble as $i => $a){
    foreach($preamble as $j => $b){
      if($i >= $j) continue;
      if($a + $b ==  $num) return true;
    }
  }
  return false;
}