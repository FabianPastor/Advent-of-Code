<?php 
$example["timestamp"] = 939;
$example["notes"]     = "7,13,x,x,59,x,31,19";

$puzzle["timestamp"] = 1015292;
$puzzle["notes"]     = "19,x,x,x,x,x,x,x,x,41,x,x,x,x,x,x,x,x,x,743,x,x,x,x,x,x,x,x,x,x,x,x,13,17,x,x,x,x,x,x,x,x,x,x,x,x,x,x,29,x,643,x,x,x,x,x,37,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,23";

$input = $puzzle;



$timestamp = $input["timestamp"];
$busesID = array_filter(explode(",",$input["notes"]), function($item){return ($item!=="x");});

$bus = searchNextBus($timestamp,$busesID);
$departure_time = $bus["time"] - $timestamp;
echo "Next Bus is at {$bus["time"]} with an id of {$bus["busid"]}".PHP_EOL;
echo "It departs in {$bus["time"]} - {$timestamp} = {$departure_time} ".PHP_EOL;
echo "The solution is: ".$bus["busid"]*$departure_time.PHP_EOL;

function searchNextBus($timestamp,$busesID){
  for($i=$timestamp; $i<100000000000;$i++ ){
    foreach($busesID as $id){
      if($i%$id == 0){
        return ["time" => $i, "busid" => $id];
      }
    }
  }
}
