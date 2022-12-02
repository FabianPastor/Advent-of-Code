<?php
//Contains the $input as string
require_once "../includes/functions.php";
$inputs = array_map("trim",explode("\n",trim($input)));

const ROCK = 0;
const PAPER = 1;
const SCISSORS = 2;

const DRAW = 0;
const PLAYER1 = -1;
const PLAYER2 = 1;

$Score        = [ PLAYER1 => 0,       DRAW   => 3,     PLAYER2  => 6        ];
$ElfHands     = [ "A"     => ROCK,    "B"    => PAPER, "C"      => SCISSORS ];
$HumanHandsP1 = [ "X"     => ROCK,    "Y"    => PAPER, "Z"      => SCISSORS ];
$HumanHandsP2 = [ "X"     => PLAYER1, "Y"    => DRAW,  "Z"      => PLAYER2  ];

$scoreSumP1 = 0;
$scoreSumP2 = 0;
foreach($inputs as $moves){
  [$playerElf, $playerHuman] = array_map("trim",explode(" ",$moves));
  $playerElfMove = $ElfHands[$playerElf];
  
  //Part 1
  $playerHumanMoveP1 = $HumanHandsP1[$playerHuman];
  $gameStatusP1 =  (($playerElfMove == $playerHumanMoveP1)?DRAW:
                       (((($playerElfMove + 2)%3) == $playerHumanMoveP1)?PLAYER1:PLAYER2));
  $scoreP1 = ($playerHumanMoveP1+1) + $Score[$gameStatusP1];
  $scoreSumP1 += $scoreP1;
  
  //Part 2
  $gameStatusP2 = $HumanHandsP2[$playerHuman]; 
  $playerHumanMoveP2 = match($gameStatusP2){
    DRAW    => $playerElfMove,
    PLAYER1 => (($playerElfMove + 2)%3),
    PLAYER2 => (($playerElfMove + 1)%3),
    default => null,
  };

  $scoreP2 = ($playerHumanMoveP2+1) + $Score[$gameStatusP2];
  $scoreSumP2 += $scoreP2;
  
}
echo "Final Score Part1: $scoreSumP1".PHP_EOL;
echo "Final Score for Part2: $scoreSumP2".PHP_EOL;

