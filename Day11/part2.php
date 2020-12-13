<?php 
$example       = "example_input.txt";
$puzzle        = "puzzle_input.txt";

$filename = $puzzle;

$input = trim(file_get_contents($filename));

//echo "$input".PHP_EOL;

$places_lines = array_map("trim",explode(PHP_EOL, $input));


$places = [];
foreach($places_lines as $lines){
  $places[] = str_split($lines);
}
$size_y = count($places);
$size_x = count($places[0]);
echo "Our grid is {$size_x}x{$size_y}".PHP_EOL;



$last_final = $input;
for($i = 0; $i <100000; $i++){
  //echo "Iteration $i".PHP_EOL;
  $places_new = $places;
  for($y = 0; $y < $size_y; $y++ ){
    for($x = 0; $x < $size_x; $x++ ){
      //echo " $i - Checking {$y}, {$x}: {$places[$y][$x]}".PHP_EOL;
      switch($places[$y][$x]){
        case "L":
          //Check 8 positions
          $finished = [];
          $j = 1;
          $seatsOcupied = 0;
          while(count($finished) < 8 ){
            $positions = [
              [$x,   $y-$j],
              [$x,   $y+$j],
              
              [$x-$j, $y-$j],
              [$x-$j, $y+$j],
              [$x-$j,  $y],
              
              [$x+$j, $y-$j],
              [$x+$j,  $y],
              [$x+$j, $y+$j],
            ];
            //echo " $i -   Checking $j possitions".PHP_EOL;
            foreach($positions as $k => $pos){
              if(isset($finished[$k])) continue;
              $pos = $places[$pos[1]][$pos[0]]??"X";
              
              switch($pos){
                case "#":
                  $seatsOcupied++;
                  $finished[$k] = true;
                
                break;
                case "L":
                  $finished[$k] = true;
                break;
                
                case "X":
                  $finished[$k] = true;
                break;
              }
              
              
            }
            $j++;
          }
          if($seatsOcupied == 0){
            $places_new[$y][$x] = "#";
          }
        break;
        
        
        case "#":
          $finished = [];
          $j = 1;
          $seatsOcupied = 0;
          while(count($finished) < 8 ){
            $positions = [
              [$x,   $y-$j],
              [$x,   $y+$j],
              
              [$x-$j, $y-$j],
              [$x-$j, $y+$j],
              [$x-$j,  $y],
              
              [$x+$j, $y-$j],
              [$x+$j,  $y],
              [$x+$j, $y+$j],
            ];
            foreach($positions as $k => $pos){
              if(isset($finished[$k])) continue;
              $pos = $places[$pos[1]][$pos[0]]??"X";
              
              switch($pos){
                case "#":
                  $seatsOcupied++;
                  $finished[$k] = true;
                
                break;
                case "L":
                  $finished[$k] = true;
                break;
                
                case "X":
                  $finished[$k] = true;
                break;
              }
              
              
            }
            $j++;
          }
          if($seatsOcupied >= 5){
            $places_new[$y][$x] = "L";
          }
        break;
      }
    }
  }
  $places = $places_new;
  
  
  
  
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
  
  $last_final = $final;
  //echo $final.PHP_EOL.PHP_EOL;
}
