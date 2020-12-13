<?php 
$example = "example_input.txt";
$puzzle = "puzzle_input.txt";

$filename = $example;

$input = trim(file_get_contents($filename));


$bagage_rules = explode(PHP_EOL,$input);

$my_bagname = "shiny gold";
$bagsCanContain = [];
foreach($bagage_rules as $rule){
  $bag = new Bag($rule);
  
  if($rule !== $bag->rule()){
    echo $rule.PHP_EOL;
    echo $bag->print().PHP_EOL.PHP_EOL;
  }
  // var_dump($bag);
  echo json_encode($bag).PHP_EOL;
  
  Bags::add($bag);
  if($bag->canContainBag($my_bagname)){
    $bagsCanContain[] = $bag->name;
  }
  
  
  
}
echo PHP_EOL;
$not_checked = $bagsCanContain;
$checked = [];
while(!empty($not_checked)){

  foreach($not_checked as $key => $toCheck){
    foreach(Bags::$all as $bag){
      if($bag->canContainBag($toCheck)){
        if(!in_array($bag->name, $checked)){
          $not_checked[] = $bag->name;
        }
      }
    }
    $checked[] = $toCheck;
    unset($not_checked[$key]);
  }
}
$checked = array_values(array_unique($checked));
echo json_encode($checked).PHP_EOL;
echo count(array_unique($checked))." - from - ".count(Bags::$all).PHP_EOL;


class Bags{
  public static $all;
  
  public static function add(\Bag $a){
    
    SELF::$all[$a->name] = $a;
  }
  public static function get($name){
    if(empty(SELF::$all[$name])) return false;
    return SELF::$all[$name];
  }
}

class Bag{
  public $name;
  public $container = [];
  //public $containedBy = [];
  
  
  public function __construct($rule){
    //light red     bags contain    1 bright white   bag, 2 muted yellow   bags.
    $matches = [];
    if(preg_match("/^(\w+ \w+) bags contain ([^.]+)\./", $rule, $matches) == 1){
      unset($matches[0]);
      $this->name = $matches[1];
      $contents_str = $matches[2];
      if($contents_str !== "no other bags"){
        $matches = [];
        $contents = array_map("trim",explode(",", $contents_str));
        
        foreach($contents as $bag){
          if(preg_match("/([0-9]+) (\w+ \w+) bags?/", $bag, $matches) == 1){
            $this->container[$matches[2]] = $matches[1];
          }
        }
      }
    }
  }
  
  public function rule(){
    $bags = "no other bags";
    if(!empty($this->container)){
      $bags = [];
      foreach($this->container as $name => $num){
        $bags[] = "$num $name bag".(($num>1)?"s":"");
      }
      $bags = implode(", ",$bags);
    }
    return sprintf("%s bags contain %s.",$this->name, $bags );
  }
  
  public function print(){
    echo $this->rule().PHP_EOL;
  }
  
  public function canContainBag($name){
    return isset($this->container[$name]);
  }
}