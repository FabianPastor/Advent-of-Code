<?php 
$example       = "example_input.txt";
$example_large = "example_large_input.txt";
$puzzle        = "puzzle_input.txt";

$filename = $puzzle;

$input = trim(file_get_contents($filename));


$adapters = array_map("trim",explode(PHP_EOL,$input));


$joltage_range = 3;
$joltage_device = max($adapters) + 3;
$joltage_outlet = 0;

$adapters = array_merge(["$joltage_outlet"],$adapters);
rsort($adapters, SORT_NATURAL);
$adapters = array_values($adapters);

$branches = [];

$current_adapter = "$joltage_device";
$branch = [];
$branches[$current_adapter] = &$branch;
$biggest = 0;


$first = [];
while($biggest!==-1){
  //echo "Checking {$current_adapter}".PHP_EOL;
  $biggest = -1;
  $a = ($current_adapter -1);
  $b = ($current_adapter -2);
  $c = ($current_adapter -3);
  if(in_array($a, $adapters)){
    $branch[$a] = [];
    if($biggest < $a ) $biggest = $a;
  }
  if(in_array($b, $adapters)){
    $branch[$b] = [];
    if($biggest < $b ) $biggest = $b;
  }
  if(in_array($c, $adapters)){
    $branch[$c] = [];
    if($biggest < $c ) $biggest = $c;
  }
  
  $first[$current_adapter] = array_keys($branch);
  if($biggest!==-1){
    $current_adapter = $biggest;
    $branch = &$branch[$biggest];
  }else{
    $branch = $current_adapter;
  }
}

$reversed = array_reverse($first,true);

$sums = [];

foreach($reversed as $actual => $branches){
  if($actual == "0" && $branches == []){
     $sums[$actual] = 1;
     continue;
   }
   $sums[$actual] = 0;
  foreach($branches as $item){
    $sums[$actual] += $sums[$item];
  }
}


//echo json_encode($sums,128).PHP_EOL;

echo "The amount of different combinations is: ".max($sums).PHP_EOL;