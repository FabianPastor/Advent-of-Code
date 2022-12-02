<?php 
$example       = "example_input.txt";
$example2       = "example_input2.txt";
$puzzle        = "puzzle_input.txt";

$filename = $example2;

$input = trim(file_get_contents($filename));

$memInstructions = array_map("trim",explode(PHP_EOL, $input));


$mem = new Mem;
$count = 0;
$mask_floating = 0;
$total_combinations = 0;
$currentMask = [
  0 => bindec("111111111111111111111111111111111111"),
  1 => bindec("000000000000000000000000000000000000"),
];
foreach($memInstructions as $instruction){
  list($type, $value) = array_map("trim", explode(" = ",$instruction));
  if($type == "mask"){
    $mask_floating = substr_count($value, "X");
    $number_of_results = pow($mask_floating, 2);
    echo "Mask has {$number_of_results} different combinations".PHP_EOL;
    
    
    $currentMask[0] = bindec(str_replace(["X"], ["1"], $value));
    $currentMask[1] = bindec(str_replace(["X"], ["0"], $value));
    $currentMask[2] = bindec(str_replace(["1", "X"], ["0","1"], $value));
    
    
    
    //echo "Mask has {$mask_floating} X".PHP_EOL;
    $total_combinations+=$number_of_results;
    continue;
  }
  $memDir = substr($type, 4, -1);
  
  $addresses = generateMemAddresses($currentMask, $memDir);
  $mem->addBatch($addresses, $memDir);
}
$mem->print();
echo "The sum of all Mem values is: ".$mem->getSum().PHP_EOL;

echo "Total Combinations: ".$total_combinations.PHP_EOL;



function generateMemAddresses($mask, $address){
  $addresses = [];
  
  
  
  
  echo lpad36(decbin($address)    )." {$address}".PHP_EOL.
       lpad36(decbin($mask[0]))." Mask 0".PHP_EOL;
  
  $address = $mask[0] & $address;
  
  echo lpad36(decbin($address))." {$address}".PHP_EOL.PHP_EOL;
  
  echo lpad36(decbin($address)    )." {$address}".PHP_EOL.
       lpad36(decbin($mask[1]))." Mask 1".PHP_EOL;
  $address = $mask[1] | $address;
  
  
  echo lpad36(decbin($address))." {$address}".PHP_EOL.PHP_EOL."-----".PHP_EOL;
  
  $addresses = [$address];
  return $addresses;
}

function lpad36($bin){
  return str_pad($bin, 36 , "0" , STR_PAD_LEFT);
  
}

class Mem{
  private $mem = [];
  
  public function add($address, $value){
    $this->mem[$address] = $value;
  }
  
  public function addBatch($bulkAddresses, $value){
    foreach($bulkAddresses as $address){
      $this->mem[$address] = $value;
    }
  }
  
  public function getCount(){
    return count($this->mem);
  }
  
  public function getSum(){
    return array_sum($this->mem);
  }
  
  public function print(){
    echo json_encode($this->mem,128).PHP_EOL;
  }
}