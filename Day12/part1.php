<?php 
$example       = "example_input.txt";
$puzzle        = "puzzle_input.txt";

$filename = $puzzle;

$input = trim(file_get_contents($filename));

$instructions = array_map("trim",explode(PHP_EOL, $input));


$verbose = false;
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
  private $v = false;
  
  public function __construct($verbose = false){
    $this->v = $verbose;
  }
  
  public function executeInstruction($instruction){
    if($this->v) echo "Instruction: {$instruction}".PHP_EOL;
    $direction = substr($instruction,0,1);
    $ammount = substr($instruction,1);
    $this->move($direction, $ammount);
  }
  
  public function move($direction, $ammount){
    
    switch($direction){
      case Direction::FORWARD:
        $current_direction = $this->current_direction;
      break;
      
      case Direction::LEFT:
        $turns = -1 * ($ammount/90);
      case Direction::RIGHT:
        $turns = $turns ?? $ammount/90;
        $ammount = 0;
        if($this->v) echo "  Turns: {$turns}".PHP_EOL;
        
        $aux = ($this->current_direction + $turns) % 4;
        $this->current_direction = $aux + (($aux < 0)?4:0);

        $current_direction = $this->current_direction;
      break;
      
      case Direction::NORTH:
        $current_direction = Cardinal::NORTH;
      break;
      case Direction::SOUTH:
        $current_direction = Cardinal::SOUTH;
      break;
      case Direction::EAST:
        $current_direction = Cardinal::EAST;
      break;
      case Direction::WEST:
        $current_direction = Cardinal::WEST;
      break;
    }
    
    if($this->v) echo "  Current Direction: ".Cardinal::TEXT[$current_direction]." moving {$ammount}".PHP_EOL;
    $this->moved[Cardinal::TEXT[$current_direction]] += $ammount;
    if($this->v) {
      $this->draw();
      echo PHP_EOL.PHP_EOL;
    }
  }
  public function getPosition(){
    return abs($this->moved[Direction::NORTH] - $this->moved[Direction::SOUTH]) + abs($this->moved[Direction::EAST] - $this->moved[Direction::WEST]);
  }
  
  public function draw(){
    echo "┏━━━━━━━━━━━━━━━━┓".PHP_EOL;
    echo "┃ ".sprintf( "%-8s %-5s %s" , "North: ", $this->moved[Direction::NORTH],"┃").PHP_EOL;
    echo "┃ ".sprintf( "%-8s %-5s %s" , "South: ", $this->moved[Direction::SOUTH],"┃").PHP_EOL;
    echo "┃ ".sprintf( "%-8s %-5s %s" , "East: ",  $this->moved[Direction::EAST ],"┃").PHP_EOL;
    echo "┃ ".sprintf( "%-8s %-5s %s" , "West: ",  $this->moved[Direction::WEST ],"┃").PHP_EOL;
    echo "┗━━━━━━━━━━━━━━━━┛".PHP_EOL.PHP_EOL;
    echo "E/W + N/S Relation : ".$this->getPosition().PHP_EOL;
  }
  
  
}
