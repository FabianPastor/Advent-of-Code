<?php 
$example = "example_input.txt";
$puzzle = "puzzle_input.txt";

$filename = $puzzle;

$input = trim(file_get_contents($filename));

$numberList = explode("\n",$input);

$sum = 2020;
foreach($numberList as $i => $a){
  foreach($numberList as $j => $b){
    foreach($numberList as $k => $c){
      if(($i >= $j) || ($i >= $k && $j >= $k)) continue;
      
      if( ($a+$b+$c) == $sum){
        $x = $a;
        $y = $b;
        $z = $c;
      }
    }
  }
}

echo "The 2 entries that sum to {$sum} are {$x}, {$y} and {$z}; Multiplied: ".($y*$x*$z).PHP_EOL;