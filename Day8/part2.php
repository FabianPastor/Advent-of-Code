<?php 
$example = "example_input.txt";
$puzzle = "puzzle_input.txt";

$filename = $puzzle;

$input = trim(file_get_contents($filename));

$instructions = array_map("trim",explode(PHP_EOL,$input));



//Global Variables
$accumulator = 0;
$totalInstructions = count($instructions);


$testing = "jmp";
$inverse = (($testing=="jmp")?"nop":"jmp");
$jmps = [];
//Getting all nops or jmps
for($pointer = 0; $pointer < $totalInstructions; $pointer++){
  list($instruction,$operation) = explode(" ",$instructions[$pointer]);
  if($instruction == $testing && !in_array($pointer, $jmps)){
    $jmps[] = $pointer;
    //echo "Pointer {$pointer} added jmps ".count($jmps).PHP_EOL;
  }
}

$max_iterations = 10000;
foreach($jmps as $num => $injectedPointer){
  $accumulator = 0;
  //echo "Testing $injectedPointer ".($num+1)."/".count($jmps).PHP_EOL;
  $finished = true;
  for($pointer = 0, $i = 0; $pointer < $totalInstructions; $pointer++,$i++){
    list($instruction,$operation) = explode(" ",$instructions[$pointer]);
    
    if($pointer == $injectedPointer) {
      //echo "Injected on pointer {$pointer}".PHP_EOL;
      $instruction = $inverse;
    }
    
    
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
    
    
    if($i > $max_iterations){
      //echo "Breaking...".PHP_EOL;
      $finished = false;
      break;
    }
  }
  if($finished)
    echo "The accumulator value is {$accumulator}".PHP_EOL;
}