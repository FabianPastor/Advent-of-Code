<?php
//Contains the $input as string
require_once "../includes/functions.php";
$inputs = array_map("trim",explode("\n",trim($input)));

function contains($e1, $e2){
  return ( ($e1[0] <= $e2[0] && $e2[1] <= $e1[1]) );
}
function overlaps($e1, $e2){
  if(contains($e1, $e2)) return true;
  return ( (($e1[0] <= $e2[0] && $e2[0] <= $e1[1]) && ($e1[1] < $e2[1])) );
}

function P1($e1, $e2){ return contains($e1, $e2) || contains($e2, $e1); }
function P2($e1, $e2){ return overlaps($e1, $e2) || overlaps($e2, $e1); }

$assignementsP1 = 0;
$assignementsP2 = 0;
foreach($inputs as $pairedElfs){
  $elfs = explode( ",", $pairedElfs );
  $elf1 = explode( "-", $elfs[0] );
  $elf2 = explode( "-", $elfs[1] );
  
  if( P1($elf1, $elf2) ) $assignementsP1++;
  if( P2($elf1, $elf2) ) $assignementsP2++;
}
echo "Assignements Part 1: ".$assignementsP1.PHP_EOL;
echo "Assignements Part 2: ".$assignementsP2.PHP_EOL;