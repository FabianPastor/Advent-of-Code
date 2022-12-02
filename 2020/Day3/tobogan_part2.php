<?php 
$example = "example_input.txt";
$puzzle = "puzzle_input.txt";
$puzzle_michael = "puzzle_michael.txt";

$filename = $puzzle;

$input = trim(file_get_contents($filename));


$forestInput  = str_replace([".","#"], ["0","1"], $input);
$forestLines  = explode(PHP_EOL, $forestInput);
$cuadrantSize = strlen($forestLines[0]);
$forestLines  = array_map("str_split",$forestLines);

$slopes = [
  [1, 1],
  [3, 1],
  [5, 1],
  [7, 1],
  [1, 2],
];

$result = 1;
foreach($slopes as $slope){
  list($right, $down) = $slope;
  $pos = 0;
  $count = 0;
  foreach($forestLines as $i => $line){
    if($i == 0) continue; //just ignore the line 0
    if($i % $down != 0) continue; //ignore all lines multiple of the time
    $pos = ($pos + $right) % $cuadrantSize; //Counts for the move 3 to the right and if we go over the limit just start at the beginning
    $count += $line[$pos]; //Just add up the numbers either 0 or 1;
  }
  echo "With Right {$right}, down {$down} we encountered {$count} trees.".PHP_EOL;
  $result *= $count;
}
echo "Muliplied Together: $result".PHP_EOL;

