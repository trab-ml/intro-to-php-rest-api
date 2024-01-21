<?php

error_reporting(E_ALL); // Enable error reporting for debugging

// Set necessary headers for CORS and response content type
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: PUT');
header('Access-Control-Allow-Headers: Content-type, Access-Control-Allow-Headers, Authorization, X-request-With');

// Include the required functions
require_once "utils.php";

// Get the HTTP request method
$requestMethod = $_SERVER["REQUEST_METHOD"];

// Check if the request method 
if ($requestMethod == "PUT") {

    $inputData = json_decode(file_get_contents("php://input"), true);
    if (empty($inputData)) {
        $updateCustomer = updateCustomer($conn, $_POST, $_GET);

    } else {
        $updateCustomer = updateCustomer($conn, $inputData, $_GET);
    }

    echo $updateCustomer;

} else {
    // return a 405 Method Not Allowed response when indeed
    createResponse(405, $requestMethod . ' Method Not Allowed', "HTTP/1.0 405 Method Not Allowed");
}

?>
