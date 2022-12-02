<?php 
$example = "example_input.txt";
$puzzle = "puzzle_input.txt";

$filename = $example;

$input = trim(file_get_contents($filename));


$forestInput  = str_replace([".","#"], ["0","1"], $input);
$forestLines  = explode(PHP_EOL, $forestInput);
$cuadrantSize = strlen($forestLines[0]);
$forestLines  = array_map("str_split",$forestLines);

$pos = 0;
$count = 0;
foreach($forestLines as $i => $line){
  if($i == 0) continue; //Counts as the move 1 down, offsets all the comming 
  $pos = ($pos+3) % $cuadrantSize; //Counts for the move 3 to the right and if we go over the limit just start at the beginning
  $count += $line[$pos]; //Just add up the numbers either 0 or 1;
}
echo "We encountered ".$count." trees.".PHP_EOL;