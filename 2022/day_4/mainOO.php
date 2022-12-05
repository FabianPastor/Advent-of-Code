<?php
//Contains the $input as string
require_once "../includes/functions.php";
$inputs = array_map("trim",explode("\n",trim($input)));

class Elf_Asignement{
  public int $min;
  public int $max;
  
  public function __construct(string $elf)
  {
    [ $this->min, $this->max ] = explode("-", $elf);
  }
}

class ElfsPair{
  private Elf_Asignement $e1;
  private Elf_Asignement $e2;
  
  public function __construct(string $assignements)
  {
    [ $e1, $e2 ] = explode(",", $assignements);
    $this->e1 = new Elf_Asignement($e1);
    $this->e2 = new Elf_Asignement($e2);
  }
  
  public function overlapped(){
    if($this->contained()) return true;
    return ( (($this->e1->min <= $this->e2->min && $this->e2->min <= $this->e1->max) && ($this->e1->max < $this->e2->max)) ||
             (($this->e2->min <= $this->e1->min && $this->e1->min <= $this->e2->max) && ($this->e2->max < $this->e1->max))  );
  }
  
  public function contained(){
    return ( ($this->e1->min <= $this->e2->min && $this->e2->max <= $this->e1->max) ||
             ($this->e2->min <= $this->e1->min && $this->e1->max <= $this->e2->max)  );
  }
}


$TotalAssignementsP1 = 0;
$TotalAssignementsP2 = 0;
foreach($inputs as $assignement){
  $pair = new ElfsPair($assignement);
  
  if( $pair->contained()  ) $TotalAssignementsP1++;
  if( $pair->overlapped() ) $TotalAssignementsP2++;
}
echo "Assignements Part1: ".$TotalAssignementsP1.PHP_EOL;
echo "Assignements Part2: ".$TotalAssignementsP2.PHP_EOL;


