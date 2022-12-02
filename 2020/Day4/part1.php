<?php 
$example = "example_input.txt";
$puzzle = "puzzle_input.txt";

$filename = $puzzle;

$input = trim(file_get_contents($filename));

$passports_str = explode(PHP_EOL.PHP_EOL, $input);

$valid = 0;
foreach($passports_str as $passport_str){
  $Passport = [];
  $passport_str = str_replace(PHP_EOL, " ", $passport_str);
  $pass_values  = explode(" ",$passport_str);
  foreach($pass_values as $value_str){
    list($name,$value) = explode(":",$value_str);
    $Passport[$name] = $value;
  }
  
  $valid += (isValid($Passport)?1:0);
}
echo $valid.PHP_EOL;

function isValid($passport){
  $fields_required = [
    "byr",
    "iyr", 
    "eyr",
    "hgt",
    "hcl",
    "ecl",
    "pid",
    //"cid",
  ];
  
  $result = array_diff($fields_required, array_keys($passport) );
  return empty($result);
}