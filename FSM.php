<?php

/**
 * Finite state machine to accept the regular expression  /baa+!/
 */

// define accept states
$accept = [false,false,false,false,true];

// state table
$fsm = [
     0 => ["b" => 1,"a" => "","!" =>""],
     1 => ["b" => "","a" => 2,"!" =>""],    
     2 => ["b"=>"","a"=>3,"!"=>0],
     3 => ["b"=>"","a"=>3,"!"=>4],
     4 => ["b"=>"","a"=>"","!"=>""]
];

// start state
$state = 0;

// get input from cli
echo "Enter input : ";
$handle = fopen ("php://stdin","r");
$line = fgets($handle);

// loop input characters
for($i = 0 ; $i < strlen($line) ; $i++){
    $current_input = substr($line, $i, 1);

    // take the transtion
    $state = empty($fsm[$state][$current_input]) ? $state : $fsm[$state][$current_input] ;
}

if($accept[$state])
{
    echo "Input Accepted\n";
}
else
    echo "Input Rejected\n";