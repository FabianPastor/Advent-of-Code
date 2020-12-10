<?php 

$example = "example_input.txt";
$puzzle = "puzzle_input.txt";
$puzzle_michael = "puzzle_michael.txt";

$filename = $example;

$input = trim(file_get_contents($filename));

$forestInput    = str_replace([".","#"], ["▪️","🌲"], $input);

$forestInput = explode("\n", $forestInput);

foreach($forestInput as $line){
  echo str_repeat($line, 5) .PHP_EOL;
  
}
echo PHP_EOL.PHP_EOL;