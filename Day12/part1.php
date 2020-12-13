<?php 
$example       = "example_input.txt";
$puzzle        = "puzzle_input.txt";

$filename = $example;

$input = trim(file_get_contents($filename));

$instructions = array_map("trim",explode(PHP_EOL, $input));


$verbose = false;
$ship = new Ship($verbose);
$ship->drawGrid();
foreach($instructions as $instruction){
  echo " -------------------------------- ".PHP_EOL;
  $ship->executeInstruction($instruction);
  $ship->drawGrid();
}
echo " -------------------------------- ".PHP_EOL;
$ship->print();





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
  const EMOJI = [
    SELF::NORTH => "👆",
    SELF::EAST  => "👉",
    SELF::SOUTH => "👇",
    SELF::WEST  => "👈",
  ];
}
// class CardinalText{
//   const NORTH   = "N";
//   const EAST    = "E";
//   const SOUTH   = "S";
//   const WEST    = "W";
// }


class Ship{
  private $gridSize = 20;
  private $x = 0;
  private $y = 0;
  private $grid = [];
  
  
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
    $this->initGrid();
    
  }
  
  public function initGrid(){
    
    for( $i = 0; $i < $this->gridSize ; $i++  ){
      for( $j = 0; $j < $this->gridSize ; $j++ ){
          $this->grid[$i][$j] = ".";
      }
    }
    $this->grid[$this->y][$this->x] = "#";
  }
  
  public function updateGrid($y, $x, $direction = false){
    
    for( $i = 0; $i < $this->gridSize ; $i++  ){
      for( $j = 0; $j < $this->gridSize ; $j++ ){
        if($this->grid[$i][$j] == "#"){
          if($direction !== false){
            $this->grid[$i][$j] = Cardinal::EMOJI[$direction];
          }
        }
      }
    }
    $this->y = $y;
    $this->x = $x;
    $this->grid[$y][$x] = "#";
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
    
    $this->moveOnGrid($current_direction, $ammount);
    
    if($this->v) {
      $this->print();
      echo PHP_EOL.PHP_EOL;
    }
  }
  
  public function moveOnGrid($direction, $ammount){
    
    $x = $this->x;
    $y = $this->y;
    switch($direction){
      case Cardinal::NORTH:
        $y -= $ammount;
        if($y < 0) $y = 0;
      break;
      case Cardinal::SOUTH:
        $y += $ammount;
        if($y > $this->gridSize) $y = ($this->gridSize-1);
      break;
      
      case Cardinal::EAST:
        $x += $ammount;
        if($x > $this->gridSize) $x = ($this->gridSize-1);
      break;
      case Cardinal::WEST:
        $x -= $ammount;
        if($x < 0) $x = 0;
      break;
    }
    $this->updateGrid($y, $x, $direction);
  }
  public function getPosition(){
    return abs($this->moved[Direction::NORTH] - $this->moved[Direction::SOUTH]) + abs($this->moved[Direction::EAST] - $this->moved[Direction::WEST]);
  }
  
  public function print(){
    echo "┏━━━━━━━━━━━━━━━━┓".PHP_EOL;
    echo "┃ ".sprintf( "%-8s %-5s %s" , "North: ", $this->moved[Direction::NORTH],"┃").PHP_EOL;
    echo "┃ ".sprintf( "%-8s %-5s %s" , "South: ", $this->moved[Direction::SOUTH],"┃").PHP_EOL;
    echo "┃ ".sprintf( "%-8s %-5s %s" , "East: ",  $this->moved[Direction::EAST ],"┃").PHP_EOL;
    echo "┃ ".sprintf( "%-8s %-5s %s" , "West: ",  $this->moved[Direction::WEST ],"┃").PHP_EOL;
    echo "┗━━━━━━━━━━━━━━━━┛".PHP_EOL.PHP_EOL;
    echo "E/W + N/S Relation : ".$this->getPosition().PHP_EOL;
  }
  
  public function drawGrid(){
    foreach($this->grid as $line){
      $cells = [];
      foreach($line as $cell){
        switch($cell){
          case "#":
            $cells = $this->mergeCells($cells, $this->cellShip());
          break;
          case ".":
            $cells = $this->mergeCells($cells, $this->cellEmpty());
          break;
          
          case Cardinal::EMOJI[Cardinal::NORTH]:
          $cells = $this->mergeCells($cells, $this->cellDirection(Cardinal::NORTH));
        break;
          case Cardinal::EMOJI[Cardinal::EAST]:
          $cells = $this->mergeCells($cells, $this->cellDirection(Cardinal::EAST));
        break;
          case Cardinal::EMOJI[Cardinal::SOUTH]:
          $cells = $this->mergeCells($cells, $this->cellDirection(Cardinal::SOUTH));
        break;
          case Cardinal::EMOJI[Cardinal::WEST]:
            $cells = $this->mergeCells($cells, $this->cellDirection(Cardinal::WEST));
          break;
        }
      }
      $this->drawCellLine($cells);
    }
  }
  
  public function mergeCells($a, $b){
    if(empty($a)){
      return $b;
    }
    $str = [];
    foreach($a as $i => $line){
      $str[] = $a[$i].$b[$i];
    }
    return $str;
    
  }
  
  public function drawCellLine($cells){
    echo implode(PHP_EOL,$cells).PHP_EOL;
  }
  
  public function cellShip(){
    
    $d = $this->current_direction;
    $emoji = Cardinal::EMOJI[$d];
    
    $str    = [];
    $str [] =        "┏━━━━━━━━┓";
    $str [] = sprintf( "┃%2s %-2s %2s┃" , ""                                  , (($d == Cardinal::NORTH)?$emoji:"") , ""                                                     );
    $str [] = sprintf( "┃%2s %-2s %2s┃" , (($d == Cardinal::WEST)?$emoji:"")  , "⛵️"                                 , (($d == Cardinal::EAST)?$emoji:"") );
    $str [] = sprintf( "┃%2s %-2s %2s┃" , ""                                  , (($d == Cardinal::SOUTH)?$emoji:"") , ""                                                    );
    $str [] =        "┗━━━━━━━━┛";
    
    return $str;
  }
  public function cellEmpty(){
    $str    = [];
    $str [] =        "┏━━━━━━━━┓";
    $str [] =  sprintf( "┃%2s %-2s %2s┃" , ""  , "" , "");
    $str [] =  sprintf( "┃%2s %-2s %2s┃" , ""  , "" , "");
    $str [] =  sprintf( "┃%2s %-2s %2s┃" , ""  , "" , "");
    $str [] =         "┗━━━━━━━━┛";
    return $str;
  }
  public function cellDirection($direction){
    $emoji = Cardinal::EMOJI[$direction];
    
    $str    = [];
    $str [] =        "┏━━━━━━━━┓";
    $str [] =  sprintf( "┃%2s %-2s %2s┃" , ""  , "" , "");
    $str [] =  sprintf( "┃%2s %-2s %2s┃" , ""  , "$emoji" , "");
    $str [] =  sprintf( "┃%2s %-2s %2s┃" , ""  , "" , "");
    $str [] =         "┗━━━━━━━━┛";
    return $str;
  }
  
  
}
