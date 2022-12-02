<?php 
$example = "example_input.txt";
$puzzle = "puzzle_input.txt";

$filename = $puzzle;

$input = trim(file_get_contents($filename));

$numbers = array_map("trim",explode(PHP_EOL,$input));



$preambleSize = 24;
$numberNotValid = 375054920;

$preambleSizes = range(2, $preambleSize);
foreach($preambleSizes as $preambleSize){
  $preamble = [];
  foreach($numbers as $i => $num){
    //echo "Number $num checked".PHP_EOL;
    if(count($preamble)<$preambleSize){
      //echo "Added number to the preamble".PHP_EOL;
      $preamble[] = $num;
    }else{
      
      if( array_sum($preamble) == $numberNotValid){
        $value = max($preamble) + min($preamble);
        echo "The sum of the biggest and the smallest numbers is: {$value}".PHP_EOL;
        echo "With a size of {$preambleSize}".PHP_EOL;
        echo var_export($preamble,true).PHP_EOL;
      }
      $preamble[] = $num;
      $preamble = array_slice ($preamble, -$preambleSize , $preambleSize);
    }
  }
}
