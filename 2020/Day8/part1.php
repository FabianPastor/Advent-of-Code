<?php 
$example = "example_input.txt";
$puzzle = "puzzle_input.txt";

$filename = $puzzle;

$input = trim(file_get_contents($filename));

$instructions = array_map("trim",explode(PHP_EOL,$input));

//Global Variables
$accumulator = 0;

$totalInstructions = count($instructions);
for($pointer = 0,$i = 0; $pointer < $totalInstructions; $pointer++,$i++){
  
  list($instruction,$operation) = explode(" ",$instructions[$pointer]);
  echo "$pointer | $instructions[$pointer] | $accumulator".PHP_EOL;
  switch($instruction){
    case "acc":
      $accumulator += $operation;
    break;
    
    case "jmp":
      $pointer += $operation-1;
    break;
    
    case "nop":
      
    break;
    
    default:
      echo "Unknown instruction ".$instructions[$pointer].PHP_EOL;
    
  }
  if($i>1000) break;
  
}