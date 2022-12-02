<?php 
$example = "example_input.txt";
$puzzle = "puzzle_input.txt";

$filename = $puzzle;

$input = trim(file_get_contents($filename));

$passports_str = explode(PHP_EOL.PHP_EOL, $input);

$valid = 0;
$total = 0;
foreach($passports_str as $passport_str){
  $pass = new Passport($passport_str);
  if($pass->isValid()){
    $valid++;
    echo sprintf("%-15s","$valid OK: ") ;
  }else{
    echo sprintf("%-15s","Error: ") ;
  }
  echo json_encode($pass).PHP_EOL;
  $pass->draw();
  //echo str_replace([PHP_EOL," "],[" ","  "], $passport_str).PHP_EOL;
  $total++;
}
echo "Number of valid passports are: {$valid} out of {$total}".PHP_EOL;


class Passport{
  
  public $pid;
  public $byr;
  public $iyr;
  public $eyr;
  public $hgt;
  public $hcl;
  public $ecl;
  public $cid;
  
  public function __construct($values){
    $passport_str = str_replace(PHP_EOL, " ", $values);
    $pass_values  = explode(" ",$passport_str);
    foreach($pass_values as $value_str){
      list($name, $value) = explode(":",$value_str);
      $this->$name = $value;
    }
  }
  
  public function areDefined(){
    if(is_null($this->byr)) return false;
    if(is_null($this->iyr)) return false;
    if(is_null($this->eyr)) return false;
    if(is_null($this->hgt)) return false;
    if(is_null($this->hcl)) return false;
    if(is_null($this->ecl)) return false;
    if(is_null($this->pid)) return false;
    //if(is_null($this->cid)) return false;
    return true;
  }
  
  public function isValid(){
    //Part 1
    // if(!$this->areDefined()) return false;
    // return true;
    
    //Part2
    return $this->validValues(); 
    
  }
  
  public function validValues(){
    if(!$this->pid_check()) return false;
    if(!$this->byr_check()) return false;
    if(!$this->iyr_check()) return false;
    if(!$this->eyr_check()) return false;
    if(!$this->hgt_check()) return false;
    if(!$this->hcl_check()) return false;
    if(!$this->ecl_check()) return false;
    //if(!$this->cid_check()) return false;
    return true;
  }
  
  
  public function byr_check(){
    if(is_null($this->byr)) return null;
    return ( 1920 <= $this->byr && $this->byr <= 2002 );
  }
  public function iyr_check(){
    if(is_null($this->iyr)) return null;
    return ( 2010 <= $this->iyr && $this->iyr <= 2020 );
  }
  public function eyr_check(){
    if(is_null($this->eyr)) return null;
    return ( 2020 <= $this->eyr && $this->eyr <= 2030 );
  }
  public function hgt_check(){
    if(is_null($this->hgt)) return null;
    $metric = substr($this->hgt, -2);
    $val = substr($this->hgt, 0, -2);
    switch($metric){
      case "cm":
        return ( 150 <= $val  && $val <= 193 );
      break;
      case "in":
        return ( 59 <= $val && $val <= 79 );
      break;
    }
    return false;
  }
  public function hcl_check(){
    if(is_null($this->hcl)) return null;
    return (preg_match('/^#[0-9a-f]{6}$/', $this->hcl) == 1);
  }
  public function ecl_check(){
    if(is_null($this->ecl)) return null;
    return in_array($this->ecl,["amb","blu","brn","gry","grn","hzl","oth"]);
  }
  public function pid_check(){
    if(is_null($this->pid)) return null;
    return (preg_match('/^[0-9]{9}$/', $this->pid) == 1);
  }
  public function cid_check(){
    if(is_null($this->cid)) return null;
    return true;
  }
  
  public function draw(){
    $red = function($str){
      return "\033[0;31m".sprintf("%-15s",$str)."\033[0m";
    };
    $yel = function($str){
      return "\033[1;33m".sprintf("%-15s",$str)."\033[0m";
    };
    
    echo "┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓".PHP_EOL;
    echo "┃ ".sprintf( "%-16s %-15s %s" , "Passport ID: ", (  $this->pid_check() ? $this->pid : $red($this->pid ?? "MISSING") ), "┃ 9 Digits" ).PHP_EOL;
    echo "┃ ".sprintf( "%-16s %-15s %s" , "Country ID: ",  (  $this->cid_check() ? $this->cid : $yel($this->cid ?? "MISSING") ), "┃ Ignore " ).PHP_EOL;
    echo "┣━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┫".PHP_EOL;
    echo "┃ ".sprintf( "%-16s %-15s %s" , "Birthday: ",    (  $this->byr_check() ? $this->byr : $red($this->byr ?? "MISSING") ), "┃ 1920 - 2002" ).PHP_EOL;
    echo "┃ ".sprintf( "%-16s %-15s %s" , "Height: ",      (  $this->hgt_check() ? $this->hgt : $red($this->hgt ?? "MISSING") ), "┃ cm 150 - 193 | in 59 -76" ).PHP_EOL;
    echo "┃ ".sprintf( "%-16s %-15s %s" , "Eyes Color: ",  (  $this->ecl_check() ? $this->ecl : $red($this->ecl ?? "MISSING") ), "┃ amb blu brn gry grn hzl oth" ).PHP_EOL;
    echo "┃ ".sprintf( "%-16s %-15s %s" , "Hair Color: ",  (  $this->hcl_check() ? $this->hcl : $red($this->hcl ?? "MISSING") ), "┃ #XXXXXX" ).PHP_EOL;
    echo "┃ ".sprintf( "%-16s %-15s %s" , "Issued: ",      (  $this->iyr_check() ? $this->iyr : $red($this->iyr ?? "MISSING") ), "┃ 2010 - 2020" ).PHP_EOL;
    echo "┃ ".sprintf( "%-16s %-15s %s" , "Expiration: ",  (  $this->eyr_check() ? $this->eyr : $red($this->eyr ?? "MISSING") ), "┃ 2020 - 2030" ).PHP_EOL;
    echo "┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛".PHP_EOL.PHP_EOL;
  }
}