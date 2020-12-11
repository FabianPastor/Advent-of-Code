<?php 
$example = "example_input.txt";
$puzzle = "puzzle_input.txt";

$filename = $puzzle;

$input = trim(file_get_contents($filename));

$boarding_numbers = explode(PHP_EOL, $input);

$biggest = 0;
foreach($boarding_numbers as $code){
  $boarding = new BoardingCard($code);
  $boarding->draw();
  if($boarding->id > $biggest){
    $biggest = $boarding->id;
  }
}
echo "The Biggest Boarding pass Seat ID is: {$biggest}".PHP_EOL;

class BoardingCard{
  
  public $code;
  public $id;
  public $row;
  public $col;
  
  public function __construct($code){
    $this->code = $code;
    $row = str_replace(["F","B"],["0","1"],substr($code,0,7));
    $this->row = bindec($row);
    $col = str_replace(["L","R"],["0","1"],substr($code,-3));
    $this->col = bindec($col);
    $this->id = $this->row * 8 + $this->col;
  }
  
  public function draw(){
    echo "  {$this->code} ".PHP_EOL;
    echo "┏━━━━━━━━━━━━━━━━━━┓".PHP_EOL;
    echo "┃ ".sprintf( "%-10s %-5s %s" , "Row: ",     $this->row, "┃" ).PHP_EOL;
    echo "┃ ".sprintf( "%-10s %-5s %s" , "Col: ",     $this->col, "┃" ).PHP_EOL;
    echo "┣━━━━━━━━━━━━━━━━━━┫".PHP_EOL;
    echo "┃ ".sprintf( "%-10s %-5s %s" , "Seat ID: ", $this->id, "┃" ).PHP_EOL;
    echo "┗━━━━━━━━━━━━━━━━━━┛".PHP_EOL.PHP_EOL;
  }
}