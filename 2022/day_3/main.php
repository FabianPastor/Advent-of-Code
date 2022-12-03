<?php
//Contains the $input as string
require_once "../includes/functions.php";
$inputs = array_map("trim",explode("\n",trim($input)));


$rucksacks = [];
$rucksacks["priorities"] = [
  "content" => [],
  "sum" => 0,
];

foreach($inputs as $index => $item){
  $rucksack = [];
  $rucksack["items"] = $item;
  $len = strlen($item)/2;
  $rucksack[1] = [
    "text" => substr($item,0,$len),
    "content"=>[],
    // "sum" => 0,
  ];
  $rucksack[2] = [
    "text" => substr($item,$len),
    "content"=>[],
    // "sum" => 0,
  ];
  
  
  $items = str_split($item);
  // echo $rucksack[1]["text"].PHP_EOL;
  $current = &$rucksack[1]["content"];
  $changed = false;
  $priorityFound = false;
  foreach($items as $i => $char){
    if(!$changed && $i >= $len) {
      // echo $rucksack[2]["text"].PHP_EOL;
      $current = &$rucksack[2]["content"];
      $changed = true;
    }
    
    $value = $char;
    $current[] = $value;
    
    if($changed){
      // $rucksack[2]["sum"] += $value;
      if(in_array($value, $rucksack[1]["content"])){
        $rucksack["same"]["$char"] = getValue($char);
        if(!$priorityFound){
          $priorityFound = true;
          $rucksacks["priorities"]["content"][] = $rucksack["same"]["$char"];
          $rucksacks["priorities"]["sum"] += $rucksack["same"]["$char"];
        }
      }
    }else{
      // $rucksack[1]["sum"] += $value;
    }
    

  }
  unset($current);


  $rucksacks[] = $rucksack;
  
}


// foreach($rucksacks as $rucksack){
//   echo json_encode($rucksack).PHP_EOL;
// }
var_dump($rucksacks);
echo "Number: ".$rucksacks["priorities"]["sum"].PHP_EOL;

function getValue(string $char):int{
  $ord = ord($char);

  return $ord - (($ord>90)?96:(65-27));
}