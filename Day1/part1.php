<?php 
$example = "example_input.txt";
$puzzle = "puzzle_input.txt";

$filename = $puzzle;

$input = trim(file_get_contents($filename));

$numberList = explode("\n",$input);

$sum = 2020;
foreach($numberList as $i => $a){
  foreach($numberList as $j => $b){
    if($i >= $j) continue;
    if( ($a+$b) == $sum){
      $x = $a;
      $y = $b;
    }
  }
}

echo "The 2 entries that sum to {$sum} are {$x} and {$y}; Multiplied: ".($y*$x).PHP_EOL;