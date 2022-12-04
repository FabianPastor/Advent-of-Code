<?php
//Contains the $input as string
require_once "../includes/functions.php";
$inputs = array_map("trim",explode("\n",trim($input)));

function isPartiallyContainedPart2($a, $b){
  if(isFullyContainedPart1($a,$b)) return true;
  return ( (($a[0] <= $b[0] && $b[0] <= $a[1]) && ($a[1] < $b[1])) ||
           (($b[0] <= $a[0] && $a[0] <= $b[1]) && ($b[1] < $a[1]))  );
}

function isFullyContainedPart1($a, $b){
  return ( ($a[0] <= $b[0] && $b[1] <= $a[1]) ||
           ($b[0] <= $a[0] && $a[1] <= $b[1])  );
}


$assignementsP1 = 0;
$assignementsP2 = 0;
foreach($inputs as $pairedElfs){
  [$elf1, $elf2] = explode(",",$pairedElfs);
  [$elf1Min, $elf1Max] = explode("-",$elf1);
  [$elf2Min, $elf2Max] = explode("-",$elf2);
  
  if(isFullyContainedPart1(
    [$elf1Min, $elf1Max],
    [$elf2Min, $elf2Max]
  )){
    $assignementsP1++;
  }
  if(isPartiallyContainedPart2(
    [$elf1Min, $elf1Max],
    [$elf2Min, $elf2Max]
  )){
    $assignementsP2++;
  }
}
echo "Assignements Part1: ".$assignementsP1.PHP_EOL;
echo "Assignements Part2: ".$assignementsP2.PHP_EOL;


