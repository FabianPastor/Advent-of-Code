<?php
//Contains the $input as string
require_once "../includes/functions.php";
$inputs = array_map("trim",explode("\n",trim($input)));

$assignements = 0;
foreach($inputs as $pairedElfs){
  [$elf1, $elf2] = explode(",",$pairedElfs);
  [$elf1Min, $elf1Max] = explode("-",$elf1);
  [$elf2Min, $elf2Max] = explode("-",$elf2);
  
  if(isPartiallyContainedPart2([$elf1Min, $elf1Max],[$elf2Min, $elf2Max])){
    $assignements++;
  }
  
  
}

echo "Assignements fully contain the other: ".$assignements.PHP_EOL;

function isPartiallyContainedPart2($a, $b){
  
  if(isFullyContainedPart1($a,$b)) return true;
  return ( (($a[0] <= $b[0] && $b[0] <= $a[1]) && ($a[1] < $b[1])) ||
           (($b[0] <= $a[0] && $a[0] <= $b[1]) && ($b[1] < $a[1]))  );
   
}

function isFullyContainedPart1($a, $b){
  return (($a[0]<=$b[0] && $b[1]<=$a[1]) ||
          ($b[0]<=$a[0] && $a[1]<=$b[1]));
}