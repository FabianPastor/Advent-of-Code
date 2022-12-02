<?php 
$example       = "example_input.txt";
$puzzle        = "puzzle_input.txt";

$filename = $example;

$input = trim(file_get_contents($filename));

$parts = array_map("trim", explode(PHP_EOL.PHP_EOL, $input));

$ticket_rules = [];
$regexp ="/(\w+(?:[ \w]+)?): ([0-9]+)\-([0-9]+) or ([0-9]+)\-([0-9]+)/";
$lines = explode(PHP_EOL, $parts[0]);
foreach($lines as $line){
  preg_match($regexp, $line, $matches);
  // echo "$line".PHP_EOL;
  $name = $matches[1];
  $range[0] = [(int)$matches[2], (int)$matches[3]];
  $range[1] = [(int)$matches[4], (int)$matches[5]];
  $ticket_rules[$name] = $range;
}

$lines = explode(PHP_EOL, $parts[1]);
$my_ticket = array_map(fn($i) => (int) $i, explode(",", $lines[1]));


$other_tickets = [];
$lines = explode(PHP_EOL, $parts[2]);
unset($lines[0]);
foreach($lines as $line){
  $other_tickets[] = array_map(fn($i) => (int) $i, explode(",", $line));
}

echo json_encode($ticket_rules).PHP_EOL;
echo json_encode($my_ticket).PHP_EOL;
echo json_encode($other_tickets).PHP_EOL;

$count = 0;
foreach($other_tickets as $ticket){
  $count += array_sum(isValidTicket($ticket));
}

echo $count.PHP_EOL;

function isValidTicket($ticket){
  global $ticket_rules;
  $invalid = [];
  $allValid = 0;
  echo "Numbers: ".json_encode($ticket).PHP_EOL;
  foreach($ticket as $number){
    $valid = 0;
    echo "Number: $number".PHP_EOL;
    $isValid = false;
    foreach($ticket_rules as $rule){

      echo "{$rule[0][0]} <= {$number} && {$number} <= {$rule[0][1]} "; 
      if($rule[0][0] <= $number && $number <= $rule[0][1]){ 
        $isValid = true;
        echo "Yes";

      }
      echo PHP_EOL;

      echo "{$rule[1][0]} <= {$number} && {$number} <= {$rule[1][1]} "; 
      if($rule[1][0] <= $number && $number <= $rule[1][1]){ 
        $isValid = true;
        echo "Yes";

      }
      echo PHP_EOL;
    }
    if($isValid){ 
      $allValid++;
      $valid++;
    }
    if(!$isValid){
      $invalid[] = $number;
    }
  }
  return ($allValid == count($ticket))?[]:$invalid;
}
