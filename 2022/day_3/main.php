<?php
//Contains the $input as string
require_once "../includes/functions.php";
$inputs = array_map("trim",explode("\n",trim($input)));


$rucksacks = [];
$priorities = [
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
          $priorities["content"][] = $rucksack["same"]["$char"];
          $priorities["sum"] += $rucksack["same"]["$char"];
        }
      }
    }else{
      // $rucksack[1]["sum"] += $value;
    }
    

  }
  unset($current);


  $rucksacks[] = $rucksack;
  
}

$group = 0;
$groups = [];
$groups[0]["elements"] = [];
$priorities = [
  "content" => [],
  "sum" => 0,
];
foreach($rucksacks as $index => $rucksack){
  // var_dump($rucksack);
  $current = &$groups[$group];
  
  $chars = str_split($rucksack["items"]);
  $elements = [];
  foreach($chars as $char){
    if(!isset($elements[$char])){
      $elements[$char] = 1;
    }
  }
  
  foreach($elements as $char => $amount){
    if(!isset($current["elements"]["$char"])){
      $current["elements"]["$char"] = 1;
    }else{
      $current["elements"]["$char"]++;
    }
  }
  
  
  
  
  // $current[]
  
  
  unset($current);
  if($index%3===2){
    
    $char = array_search(3,$groups[$group]["elements"]);
    $value = getValue($char);
    $priorities["content"][] = $char;
    $priorities["sum"] += $value;
    
    
    // $priorities["sum"] 
    
    
    
    
    
    $group++;
    $groups[$group]["elements"] = [];
  }
}
unset($groups[$group]);

// foreach($rucksacks as $rucksack){
//   echo json_encode($rucksack).PHP_EOL;
// }
// var_dump($rucksacks,$priorities);
// var_dump($groups);
echo "Number: ".$priorities["sum"].PHP_EOL;

function getValue(string $char):int{
  $ord = ord($char);

  return $ord - (($ord>90)?96:(65-27));
}