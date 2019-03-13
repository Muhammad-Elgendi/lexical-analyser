<?php

/**
 * simple lexical analyser that identifies :
 * 1 - ";" as an element of special characters
 * 2 - "+" and "-" as operators
 * 3 - "int" and "double" as keyword int and keyword double respectively
 * 4- numeric constants of the form [0-9]+
 * 5- identifiers that employ java identifiers naming rules except the letters of the keywords
 */

// define accept states
$accept = [false,
[true,"special characters"],
[true,"identifiers"],
[true,"numeric constants"],
false,false,
[true,"keyword int"],
false,false,false,false,false,
[true,"keyword double"],
[true,"operators"]];

// state table
$fsm = [
    [";" => 1,"a-z" => 2,"0-9" =>3,"i"=>4,"d"=>7,"+="=>13],
    [],    
    ["a-z-0-9"=>2],
    ["0-9"=>3],
    ["n"=>5],
    ["t"=>6],
    [],
    ["o"=>8],
    ["u"=>9],
    ["b"=>10],
    ["l"=>11],
    ["e"=>12],
    [],
    []
];

$keywords =[
    "int","double"
];

// start state
$state = 0;

// get input from cli
echo "Enter input : \n";
$handle = fopen ("php://stdin","r");
$line = fgets($handle);

// loop input characters
for($i = 0 ; $i < strlen($line) ; $i++){
    $current_input = substr($line, $i, 1);

    // preprocessing the input
    $current_input = process($current_input,$keywords);

    // take the transtion
    $state = empty($fsm[$state][$current_input]) ? $state : $fsm[$state][$current_input] ;

    if(is_array($accept[$state])){
        echo $accept[$state][1]."\n";
        $state = 0;
    }
}

if(!is_array($accept[$state])){
    echo "Goodbye!\n";
}

// preprocess input
function process($char,$keywords){

    if( $char == "+" || $char == "=")
        return "+=";

    foreach($keywords as $keyword){
        if(stripos($keyword,$char) !== false){
            return $char;
        }
    }
    if (preg_match('/[0-9]/', $char) == 1){
        return "0-9";
    }elseif(preg_match('/[a-zA-Z]/', $char) == 1){
        return "a-z";
    }elseif(preg_match('/[a-zA-Z0-9]/', $char) == 1){
        return "a-z-0-9";
    }

    return $char;
}