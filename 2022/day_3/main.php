<?php
//Contains the $input as string
require_once "../includes/functions.php";
$inputs = array_map("trim",explode("\n",trim($input)));

function getValue(string $char):int{
  $ord = ord($char);
  // return 1 + $ord - ( ($ord >= ord("a") )?ord("a"):ord("A")-26 );
  // return 1 + $ord - (($ord >= 97)?97:(65-26));
  return $ord - (($ord >= 97)?96:38);
}


$priorities = 0;
foreach($inputs as $index => $rucksack){
  $rucksack = trim($rucksack);
  $n = strlen($rucksack)/2;
  $items = str_split($rucksack);
  $items = array_map("getValue",$items);
  
  $list1 = array_slice($items, 0, $n);
  $list2 = array_slice($items, $n);
  
  foreach($list1 as $item){
    if(in_array($item, $list2)){
      $priorities += $item;
      break;
    }
  } 
}

echo "Part1 Priorities: ".$priorities.PHP_EOL;


$priorities = 0;
$groupItems = [];
foreach($inputs as $index => $rucksack){
  $items = str_split(trim($rucksack));
  $items = array_unique(array_map("getValue",$items));
  $groupItems = array_merge($groupItems, $items);
  
  if($index%3===2){
    $elements = [];
    foreach($groupItems as $key => $item){
      $elements[$item] ??= 0;
      $elements[$item]++;
    }
    $i = array_search(3,$elements);
    $priorities += $i;
    
    $groupItems = [];
  }
}

echo "Part2 Priorities: ".$priorities.PHP_EOL;