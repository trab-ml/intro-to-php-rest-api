<?php

// Set necessary headers for CORS and response content type
header('Access-Control-Allow-Origin');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: DELETE');
header('Access-Control-Allow-Headers: Content-type, Access-Control-Allow-Headers, Authorization, X-request-With');

// Include the required functions
require_once "utils.php";

// Get the HTTP request method
$requestMethod = $_SERVER["REQUEST_METHOD"];

// Check if the request method 
if ($requestMethod == "DELETE") {
    if (isset($_GET['id'])) {
        $customer = deleteCustomer($conn, $_GET);
        echo $customer;
    }

} else {
    // return a 405 Method Not Allowed response when indeed
    createResponse(405, $requestMethod . ' Method Not Allowed', "HTTP/1.0 405 Method Not Allowed");
}
