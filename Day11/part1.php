<?php 
$example       = "example_input.txt";
$puzzle        = "puzzle_input.txt";

$filename = $puzzle;

$input = trim(file_get_contents($filename));

echo "$input".PHP_EOL;

$places_lines = array_map("trim",explode(PHP_EOL, $input));


$places = [];
foreach($places_lines as $lines){
  $places[] = str_split($lines);
}
$size_y = count($places);
$size_x = count($places[0]);
echo "Our grid is {$size_x}x{$size_y}".PHP_EOL;



$last_final = $input;
for($i = 0; $i <1000; $i++){
  $places_new = $places;
  for($y = 0; $y < $size_y; $y++ ){
    for($x = 0; $x < $size_x; $x++ ){
      $positions = [
        [$x,   $y-1],
        [$x,   $y+1],
        
        [$x-1, $y-1],
        [$x-1, $y+1],
        [$x-1,  $y],
        
        [$x+1, $y-1],
        [$x+1,  $y],
        [$x+1, $y+1],
      ];
      
      switch($places[$y][$x]){
        case "L":
        //Check 8 positions
        $seatsOcupied = 0;
        foreach($positions as $pos){
          $pos = $places[$pos[1]][$pos[0]]??"X";
          if($pos === "#"){
            $seatsOcupied++;
          }
        }
        if($seatsOcupied == 0){
          $places_new[$y][$x] = "#";
        }
        break;
        case "#":
        $seatsOcupied = 0;
        foreach($positions as $pos){
          $pos = $places[$pos[1]][$pos[0]]??"X";
          if($pos === "#"){
            $seatsOcupied++;
          }
        }
        if($seatsOcupied >= 4){
          $places_new[$y][$x] = "L";
        }
        break;
      }
    }
  }
  $places = $places_new;
  
  
  
  
  $last_final = $final;
  $final = "";
  
  foreach($places_new as $lines){
    $final .= implode("",$lines).PHP_EOL;
  }
  if($final == $last_final){
    echo "Stability at: $i".PHP_EOL;
    $occupied = 0;
    for($y = 0; $y < $size_y; $y++ ){
      for($x = 0; $x < $size_x; $x++ ){
        if($places[$y][$x] == "#"){
          $occupied++;
        }
        
        
      }
    }
    echo "There are seats occupied: $occupied".PHP_EOL;
    
    break;
  }
  
  echo $final.PHP_EOL.PHP_EOL;
}
