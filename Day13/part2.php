<?php 
$example["timestamp"] = 939;
$example["notes"]     = "7,13,x,x,59,x,31,19";

$puzzle["timestamp"] = 1015292;
$puzzle["notes"]     = "19,x,x,x,x,x,x,x,x,41,x,x,x,x,x,x,x,x,x,743,x,x,x,x,x,x,x,x,x,x,x,x,13,17,x,x,x,x,x,x,x,x,x,x,x,x,x,x,29,x,643,x,x,x,x,x,37,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,23";
// $solution = 1001569619313439; Got the solution by compiling and execute the code from https://git.sr.ht/~quf/computers-are-fast-2020/

$input = $puzzle;

//All prime numbers


$busesID = explode(",",$input["notes"]);
$buses = array_filter($busesID, function($item){return ($item!=="x");});
arsort($buses, SORT_NATURAL);


 $ammount = 10000000000000000;
 $start   = 100000000000000;

//Bruteforce: Eventyally we will arive there....
echo searchNum($buses ,$start, $ammount).PHP_EOL;

function searchNum($buses, $min, $max){  
  $nbuses = count($buses);
  $found = false;
  $bus0 = max($buses);
  $bus0Key = array_search($bus0, $buses);
  unset($buses[$bus0Key]);
  $newOffset = 0;
  for($i = $min; $i < $min+$max; $i++ ){
    if($i%100000000 == 0){
      echo "Checking $i".PHP_EOL;
    }
    $num = $bus0*$i;
    $count = 0;
    $checked = [];
    foreach($buses as $j => $id){
      if((($num+($j-$bus0Key))%$id)==0){
        $checked[] = $id;
        $count++;
      }else{
        break;
      }
    }
    if($count > 3){
      echo "Processed $count - ". ($num-$bus0Key)." - $bus0, ".implode(", ",$checked).PHP_EOL;
    }
    if($count == $nbuses){
      return $num-$bus0Key;
    }
  }
  return false;
}