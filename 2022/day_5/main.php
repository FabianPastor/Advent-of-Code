<?php
//Contains the $input as string
require_once "../includes/functions.php";
// $inputs = array_map("trim",explode("\n",trim($input)));

$inputs = trim(str_replace(
  ["move "," from "," to ","    ","[","]"," "],
  ["",",",","," [_]","","",""],
$input));

[$table, $moves] = explode("\n\n",$inputs);

echo $table.PHP_EOL;
// echo $moves.PHP_EOL;

$stacks = [];
$lines = explode("\n",$table);
$lines = array_reverse($lines);
foreach($lines as $n => $line){
  if($n==0)continue;
  $items = str_split($line);
  foreach($items as $i => $item){
    if(trim($item)=="_") continue;
    $stacks[($i+1)][] = $item;
  }
}
// var_dump($stacks);
printStack($stacks);

$moves = explode("\n",$moves);

//Part 1
foreach($moves as $move){
  [$n, $src, $dst] = explode(",", $move);
  // echo "From $src move to $dst: $n times\n";
  for($i=0;$i<$n;$i++){
    if($stackElement = array_pop($stacks[$src])){
      array_push($stacks[$dst], $stackElement);
    }
  }
}

foreach($stacks as $stack){
  if($element = array_pop($stack)){
    echo $element;
  }
}
echo PHP_EOL;
printStack($stacks);


function printStack($stacks){
  
  foreach($stacks as $i => $stack){
    echo "$i) ".implode(" ",$stack).PHP_EOL;
  }
  
}