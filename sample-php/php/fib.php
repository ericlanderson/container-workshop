<?php
header("Content-Type:application/json");

if(!empty($_GET['number'])) {
    $number=$_GET['number'];
    $fib = Fibonacci($number);
	
    response(200,"Fibonacci series for ". $number .": ",$fib);
}
else {
    response(400,"Invalid Request",NULL);
}

function response($status,$status_message,$data) {
    header("HTTP/1.1 ".$status);
	
    $response['status']=$status;
    $response['status_message']=$status_message;
    $response['data']=$data;
	
    $json_response = json_encode($response);
    echo $json_response;
}

function Fibonacci(int $n) {

    $num1 = 0;
    $num2 = 1;

    $counter = 0;
    while ($counter < $n){
        $series .= " " . $num1;
        $num3 = $num2 + $num1;
        $num1 = $num2;
        $num2 = $num3;
        $counter = $counter + 1;
    }
    return $series;
}
?>
