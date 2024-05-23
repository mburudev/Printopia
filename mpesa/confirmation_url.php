<?php

    header("Content-Type: application/json");

    $response = '{
        "ResultCode": 0,
        "ResultDesc": "Confirmation received succesfully"
    }';

    //DATA 
    $mpesaResponse = file_get_contents('php://input');

    //log response 
    $logFile = "M_PesaResponse.txt";
    $jsonMpesaResponse - json_decode($mpesaResponse, true);

    //write to file 
    $log = fopen($logFile, "a");

    fwrite($log, $mpesaResponse);

    fclose($log);

    echo $response;
    ?>