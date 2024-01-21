<?php

// Set necessary headers for CORS and response content type
header('Access-Control-Allow-Origin');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Content-type, Access-Control-Allow-Headers, Authorization, X-request-With');

// Include the required functions
require_once "utils.php";

// Get the HTTP request method
$requestMethod = $_SERVER["REQUEST_METHOD"];

// Check if the request method 
if ($requestMethod == "POST") {

    $inputData = json_decode(file_get_contents("php://input"), true);
    if (empty($inputData)) {
        $storeCustomer = storeCustomer($conn, $_POST);

    } else {
        $storeCustomer = storeCustomer($conn, $inputData);

    }
     
    echo $storeCustomer;
    
} else {
   // return a 405 Method Not Allowed response when indeed
   createResponse(405, $requestMethod . ' Method Not Allowed', "HTTP/1.0 405 Method Not Allowed");
}
