<?php 
$example       = "example_input.txt";
$example_large = "example_large_input.txt";
$puzzle        = "puzzle_input.txt";

$filename = $puzzle;

$input = trim(file_get_contents($filename));


$adapters = array_map("trim",explode(PHP_EOL,$input));

natsort($adapters);

$joltage_range = 3;
$joltage_device = max($adapters) + 3;
$joltage_outlet = 0;


$sourcesSeparation = [
  0 => 0,
  1 => 0,
  2 => 0,
  3 => 0,
  4 => 0,
  10 => 0
];

$last_adapter = $joltage_outlet;
foreach($adapters as $adapter){
  $sourcesSeparation[($adapter - $last_adapter)]++;
  
  $last_adapter = $adapter;
}
$sourcesSeparation[($joltage_device - $last_adapter)]++;

 
 
echo json_encode($sourcesSeparation,128).PHP_EOL;

echo "Device Joltage: {$joltage_device}".PHP_EOL;
echo "Multiplication: ".($sourcesSeparation[1] * $sourcesSeparation[2]).PHP_EOL;


