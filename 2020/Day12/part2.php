<?php 
$example       = "example_input.txt";
$puzzle        = "puzzle_input.txt";

$filename = $puzzle;

$input = trim(file_get_contents($filename));

$instructions = array_map("trim",explode(PHP_EOL, $input));


$verbose = true;
$ship = new Ship($verbose);
foreach($instructions as $instruction){
  $ship->executeInstruction($instruction);
}
$ship->draw();





class Direction{
  const LEFT    = "L";
  const RIGHT   = "R";
  
  const FORWARD = "F";
  
  const NORTH   = "N";
  const SOUTH   = "S";
  const EAST    = "E";
  const WEST    = "W";
  
  
}

class Cardinal{
  const NORTH   = 0;
  const EAST    = 1;
  const SOUTH   = 2;
  const WEST    = 3;
  
  const TEXT = [
    SELF::NORTH => Direction::NORTH,
    SELF::EAST  => Direction::EAST,
    SELF::SOUTH => Direction::SOUTH,
    SELF::WEST  => Direction::WEST,
  ];
}
// class CardinalText{
//   const NORTH   = "N";
//   const EAST    = "E";
//   const SOUTH   = "S";
//   const WEST    = "W";
// }


class Ship{
  private $current_direction = Cardinal::EAST;
  private $moved = [
    Direction::NORTH => 0,
    Direction::SOUTH => 0,
    Direction::EAST  => 0,
    Direction::WEST  => 0,
  ];
  private $waypoint = [
    Direction::NORTH => 1,
    Direction::EAST  => 10,
  ];
  private $v = false;
  
  public function __construct($verbose = false){
    $this->v = $verbose;
  }
  
  public function executeInstruction($instruction){
    if($this->v) echo "Instruction: {$instruction}".PHP_EOL;
    $direction = substr($instruction,0,1);
    $ammount = substr($instruction,1);
    $this->exec($direction, $ammount);
  }
  
  public function exec($direction, $ammount){
    
    switch($direction){
      case Direction::FORWARD:
        $current_direction = $this->current_direction;
        $this->moveShip($ammount);
      break;
      
      case Direction::LEFT:
        $turns = -1 * ($ammount/90);
      case Direction::RIGHT:
        $turns = $turns ?? $ammount/90;
        $ammount = 0;
        if($this->v) echo "  Turns: {$turns}".PHP_EOL;
        $this->rotateWaypoint($turns);
      break;
      
      case Direction::NORTH:
        $this->waypoint[Direction::NORTH] += $ammount;
      break;
      case Direction::SOUTH:
        $this->waypoint[Direction::NORTH] -= $ammount;
      break;
      case Direction::EAST:
        $this->waypoint[Direction::EAST] += $ammount;
      break;
      case Direction::WEST:
        $this->waypoint[Direction::EAST] -= $ammount;
      break;
    }
    
    if($this->v) {
      $this->draw();
      echo PHP_EOL.PHP_EOL;
    }
  }
  public function getPosition(){
    return abs($this->moved[Direction::NORTH] - $this->moved[Direction::SOUTH]) + abs($this->moved[Direction::EAST] - $this->moved[Direction::WEST]);
  }
  
  public function rotateWaypoint($times){
    
    $direction = !($times<0);
    $times = abs($times);
    
    $new_waypoint = $this->waypoint;
    if($direction){
      for($i = 0; $i < $times; $i++){
        //if($this->v) {echo "Rotating to the "}
        $new_waypoint = [
          Direction::NORTH => -$new_waypoint[Direction::EAST],
          Direction::EAST  =>  $new_waypoint[Direction::NORTH],
        ];
      }
    }else{
      for($i = 0; $i < $times; $i++){
        $new_waypoint = [
          Direction::NORTH => $new_waypoint[Direction::EAST],
          Direction::EAST  => -$new_waypoint[Direction::NORTH],
        ];
      }
    }
    $this->waypoint = $new_waypoint;
  }
  
  public function moveShip($times){
    
    if($this->waypoint[Direction::NORTH] < 0){
      $this->moved[Direction::SOUTH] += -1 * $this->waypoint[Direction::NORTH] * $times;
    }else{
      $this->moved[Direction::NORTH] += $this->waypoint[Direction::NORTH] * $times;
    }
    
    if($this->waypoint[Direction::EAST] < 0){
      $this->moved[Direction::WEST] += -1 * $this->waypoint[Direction::EAST] * $times;
    }else{
      $this->moved[Direction::EAST] += $this->waypoint[Direction::EAST] * $times;
    }
    
  }
  
  public function draw(){
    echo "┏━━━━━━━━━━━━━━━━━━━━━━━━━━━┓".PHP_EOL;
    echo "┃ ".sprintf( "%-16s %-8s %s" , "North: ", $this->moved[Direction::NORTH],"┃").PHP_EOL;
    echo "┃ ".sprintf( "%-16s %-8s %s" , "South: ", $this->moved[Direction::SOUTH],"┃").PHP_EOL;
    echo "┃ ".sprintf( "%-16s %-8s %s" , "East: ",  $this->moved[Direction::EAST ],"┃").PHP_EOL;
    echo "┃ ".sprintf( "%-16s %-8s %s" , "West: ",  $this->moved[Direction::WEST ],"┃").PHP_EOL;
    echo "┣━━━━━━━━━━━━━━━━━━━━━━━━━━━┫".PHP_EOL;
    echo "┃ ".sprintf( "%-16s %-8s %s" , "Waypoint North: ",  $this->waypoint[Direction::NORTH ],"┃").PHP_EOL;
    echo "┃ ".sprintf( "%-16s %-8s %s" , "Waypoint East: ",  $this->waypoint[Direction::EAST ],"┃").PHP_EOL;
    echo "┗━━━━━━━━━━━━━━━━━━━━━━━━━━━┛".PHP_EOL.PHP_EOL;
    
    
    
    echo "E/W + N/S Relation : ".$this->getPosition().PHP_EOL;
  }
  
  
}
