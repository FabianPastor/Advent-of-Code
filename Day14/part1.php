<?php 
$example       = "example_input.txt";
$puzzle        = "puzzle_input.txt";

$filename = $puzzle;

$input = trim(file_get_contents($filename));

$memInstructions = array_map("trim",explode(PHP_EOL, $input));

$mem = [
  
];
$currentMask = [
  0 => bindec("111111111111111111111111111111111111"),
  1 => bindec("000000000000000000000000000000000000"),
];
foreach($memInstructions as $instruction){
  list($type, $value) = array_map("trim", explode(" = ",$instruction));
  if($type == "mask"){
    $currentMask[0] = bindec(str_replace(["X"], ["1"], $value));
    $currentMask[1] = bindec(str_replace(["X"], ["0"], $value));
    continue;
  }
  $memDir = substr($type, 4, -1);
  echo "Applying Mask to Value {$value} and storing into {$memDir} ".PHP_EOL;
  $mem[$memDir] = applyMask($currentMask, $value);
  echo "Value is now: {$mem[$memDir]}".PHP_EOL.PHP_EOL;
}

echo "Echo Mem Content: ".PHP_EOL;
echo json_encode($mem, 128).PHP_EOL;

echo "The sum of all Mem values is: ".array_sum($mem).PHP_EOL;

function applyMask($mask, $val){
  echo lpad36(decbin($val)    )." {$val}".PHP_EOL.
       lpad36(decbin($mask[0]))." Mask 0".PHP_EOL;
  $val = $mask[0] & $val;
  echo lpad36(decbin($val))." {$val}".PHP_EOL.PHP_EOL;
  
  echo lpad36(decbin($val)    )." {$val}".PHP_EOL.
       lpad36(decbin($mask[1]))." Mask 1".PHP_EOL;
  $val = $mask[1] | $val;
  echo lpad36(decbin($val))." {$val}".PHP_EOL;
  return $val;
}

function lpad36($bin){
  return str_pad($bin, 36 , "0" , STR_PAD_LEFT);
  
}