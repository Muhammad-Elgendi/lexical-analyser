<?php

// Non determinstic finite state machine simulator for NFSA.png image

// defince accept states
$accept = [false,false,false,false,true];

// state table
// $fsm = [
//      0 => ["b" => 1,"a" => "","!" =>""],
//      1 => ["b" => "","a" => 2,"!" =>""],    
//      2 => ["b"=>"","a"=>3,"!"=>0],
//      3 => ["b"=>"","a"=>3,"!"=>4],
//      4 => ["b"=>"","a"=>"","!"=>""]
// ];

$nfsm = [
    0 => ["b" => 1,"a" => "","!" =>""],
    1 => ["b" => "","a" => 2,"!" =>""],    
    2 => ["b"=>"","a"=>[3,2],"!"=>0],
    3 => ["b"=>"","a"=>3,"!"=>4],
    4 => ["b"=>"","a"=>"","!"=>""]
];

// start state
$state = 0;

// get input from cli
echo "Enter input : ";
$handle = fopen ("php://stdin","r");
$line = rtrim(fgets($handle));

// loop input characters
for($i = 0 ; $i < strlen($line) ; $i++){
    $current_input = substr($line, $i, 1);

    // take the transtion
    if(isset($nfsm[$state][$current_input]) && is_array($nfsm[$state][$current_input])){

        // pick random from array
        $random = array_rand($nfsm[$state][$current_input]);
        $state = $nfsm[$state][$current_input][$random];
    }else if(empty($nfsm[$state][$current_input])){

        // remain in the current state
        $state = $state;

    }else{
        $state = $nfsm[$state][$current_input];
    }
   
}

if($accept[$state])
{
    echo "Input Accepted\n";
}
else
    echo "Input Rejected\n";