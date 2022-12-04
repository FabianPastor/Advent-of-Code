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

function P1($e){ return contains([$e[0],$e[1]], [$e[2],$e[3]]) || contains([$e[2],$e[3]], [$e[0],$e[1]]); }
function P2($e){ return overlaps([$e[0],$e[1]], [$e[2],$e[3]]) || overlaps([$e[2],$e[3]], [$e[0],$e[1]]); }

$assignementsP1 = 0;
$assignementsP2 = 0;
foreach($inputs as $pairedElfs){
  $elfs = explode( ",", str_replace("-",",",$pairedElfs) );
  
  if( P1($elfs) ) $assignementsP1++;
  if( P2($elfs) ) $assignementsP2++;
}
echo "Assignements Part 1: ".$assignementsP1.PHP_EOL;
echo "Assignements Part 2: ".$assignementsP2.PHP_EOL;