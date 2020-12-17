<?php 
$example       = "example_input.txt";
$puzzle        = "puzzle_input.txt";

$filename = $example;

$input = trim(file_get_contents($filename));

$parts = array_map("trim", explode(PHP_EOL.PHP_EOL, $input));

$ticket_values = [];
$regexp ="/(\w+(?:[ \w]+)?): ([0-9]+)\-([0-9]+) or ([0-9]+)\-([0-9]+)/";
$lines = explode(PHP_EOL, $parts[0]);
foreach($lines as $line){
  preg_match($regexp, $line, $matches);
  // echo "$line".PHP_EOL;
  $name = $matches[1];
  $range[0] = [(int)$matches[2], (int)$matches[3]];
  $range[1] = [(int)$matches[4], (int)$matches[5]];
  $ticket_values[$name] = $range;
}

$lines = explode(PHP_EOL, $parts[1]);
$my_ticket = array_map(fn($i) => (int) $i, explode(",", $lines[1]));


$other_tickets = [];
$lines = explode(PHP_EOL, $parts[2]);
unset($lines[0]);
foreach($lines as $line){
  $other_tickets[] = array_map(fn($i) => (int) $i, explode(",", $line));
}

echo json_encode($ticket_values).PHP_EOL;
echo json_encode($my_ticket).PHP_EOL;
echo json_encode($other_tickets).PHP_EOL;

