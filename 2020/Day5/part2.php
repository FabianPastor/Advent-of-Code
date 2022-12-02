<?php 
$example = "example_input.txt";
$puzzle = "puzzle_input.txt";

$filename = $puzzle;

$input = trim(file_get_contents($filename));

$boarding_numbers = explode(PHP_EOL, $input);

$boarding_passes = [];
foreach($boarding_numbers as $code){
  $boarding_passes[] = new BoardingCard($code);
}
usort($boarding_passes, fn($a, $b) => $a->id <=> $b->id );

//Create an array with all the seats
$boardingseatid_missing = array_fill(0,127*8,"missing"); //127 rows and each row has 8 seats

//Delete the seats we already have
foreach($boarding_passes as $boarding){
  unset($boardingseatid_missing[$boarding->id]);
}
//Purge the seats that have +1 and -1
$old_id = 0;
$last_id = 0;
foreach($boardingseatid_missing as $id => $garbage){
  if($id == 0) continue;
  if($last_id == $id-1){
    $old_id = $last_id;
  }
  if($old_id == ($id-1) ){
    $old_id = $id;
    unset($boardingseatid_missing[$id]);
  }
  $last_id = $id;
}

//Grab the on in the middle.
$my_seatID = array_keys($boardingseatid_missing)[1];

echo "My seat ID is: {$my_seatID}".PHP_EOL;

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