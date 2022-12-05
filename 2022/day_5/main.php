<?php
//Contains the $input as string
require_once "../includes/functions.php";
//Change some strings to easy process the data.
$inputs = trim(str_replace(
  ["move "," from "," to ","    ","[","]"," "],
  [""     ,","     ,","   ," [_]","" ,"" ,""],
$input));

[$table, $moves] = explode("\n\n",$inputs);

// echo $table.PHP_EOL;
// echo $moves.PHP_EOL;

//Create the stacks of crates
$stacks = [];
$lines = explode("\n",$table);
$lines = array_reverse($lines);
foreach($lines as $n => $line){
  if($n==0)continue;
  $crates = str_split($line);
  foreach($crates as $i => $crate){
    if(trim($crate)=="_") continue;
    $stacks[($i+1)][] = $crate;
  }
}
echo "\nCrates: \n";
printStacks($stacks);

//Reorder the stacks with the movements specified
$moves = explode("\n",$moves);

$stacksP1 = moveCratesP1($moves, $stacks);
echo "\nCrates after moving Part1:\n";
printStacks($stacksP1);
echo "First Crates: ".getFirstCrates($stacksP1).PHP_EOL;

$stacksP2 = moveCratesP2($moves, $stacks);
echo "\nCrates after moving Part2:\n";
printStacks($stacksP2);
echo "First Crates: ".getFirstCrates($stacksP2).PHP_EOL;


function moveCratesP1($moves, $stacks){
  foreach($moves as $move){
    [$n, $src, $dst] = explode(",", $move);
    for($i=0; $i<$n; $i++){
      if($crate = array_pop($stacks[$src])){
        array_push($stacks[$dst], $crate);
      }
    }
  }
  return $stacks;
}

function moveCratesP2($moves, $stacks){
  foreach($moves as $move){
    [$n, $src, $dst] = explode(",", $move);
    if($crates = array_splice($stacks[$src],-$n)){
      $stacks[$dst] = array_merge($stacks[$dst], $crates);
    }
  }
  return $stacks;
}

function getFirstCrates($stacks){
  $str = "";
  foreach($stacks as $stack){
    if($crate = array_pop($stack)){
      $str .= $crate;
    }
  }
  return $str;
}

function printStacks($stacks){
  $text = [];
  $cols = count($stacks);
  foreach($stacks as $i => $stack){
    $text[0][$i] = " $i ";
    foreach($stack as $j => $crate){
      if(!isset($text[($j+1)][$i])){
        $text[($j+1)] = array_fill(1,$cols,"   ");
      }
      $text[($j+1)][$i] = "[$crate]";
    }
  }
  $text = array_reverse($text);
  foreach($text as $strings){
    echo implode(" ",$strings).PHP_EOL;
  }
}