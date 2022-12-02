<?php
require_once "../includes/functions.php";

$elfs = explode("\n\n", $input);
$elf_weights = [];

foreach($elfs as $elf_index => $kcal){
  $elf = &$elfs[$elf_index];
  $elf = [
    // "main" => "$kcal",
    "foods" => array_map(fn($i)=>trim($i),explode("\n",$kcal)),
  ];
  $elf["sum"] = array_sum($elf["foods"]);
  $elf_weights[$elf_index] = $elf["sum"];
  unset($elf);
}

echo "\nElfs Sorted: ".PHP_EOL;
arsort($elf_weights);
foreach($elf_weights as $key => $kcal){
  echo "  ".str_pad($key+1,10," ",STR_PAD_RIGHT)." => $kcal".PHP_EOL;
}
echo "First Elf has: ".reset($elf_weights).PHP_EOL;


echo "\nTop 3:".PHP_EOL;
$top3 = array_slice($elf_weights,0,3,true);
$top3_sum = array_sum($top3);
foreach($top3 as $key => $kcal){
  echo "  ".str_pad($key+1,10," ",STR_PAD_RIGHT)." => $kcal".PHP_EOL;
  
}
echo "Sum of the Top 3: $top3_sum".PHP_EOL;