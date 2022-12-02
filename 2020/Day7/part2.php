<?php 
$example = "example_input.txt";
$puzzle = "puzzle_input.txt";

$filename = $puzzle;

$input = trim(file_get_contents($filename));

$bagage_rules = explode(PHP_EOL,$input);


$my_bagname = "shiny gold";
foreach($bagage_rules as $rule){
  $bag = new Bag($rule);
  Bags::add($bag);
}


$value = countAllInnerBags($my_bagname);
echo "Required individual bags inside '{$my_bagname}' are {$value}".PHP_EOL;






function countAllInnerBags($name){
  $bag = Bags::get($name);
  
  if(!empty($bag->container)){
   $count = 0;
   foreach($bag->container as $newBagName => $num) {
     $a = countAllInnerBags($newBagName);
     if($a){
       $count += $num + $a*$num;
     }else{
       $count += $num;
     }
   }
   return $count;
  }else{
    return false;
  }
}


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
  public $containedBy = [];
  
  
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