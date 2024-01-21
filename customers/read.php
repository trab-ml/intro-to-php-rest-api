<?php

// Set necessary headers for CORS and response content type
header('Access-Control-Allow-Origin');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: GET');
header('Access-Control-Allow-Headers: Content-type, Access-Control-Allow-Headers, Authorization, X-request-With');

// Include the required functions
require_once "utils.php";

// Get the HTTP request method
$requestMethod = $_SERVER["REQUEST_METHOD"];

// Check if the request method
if ($requestMethod == "GET") {

    if (isset($_GET['id'])) {
        // Fetch customer data by ID and echo the result
        $customer = getCustomer($conn, $_GET);
        echo $customer;
    } else {
        // Fetch list of all customers and echo the result
        $customerList = getCustomerList($conn);
        echo $customerList;
    }

} else {
    // return a 405 Method Not Allowed response when indeed
    createResponse(405, $requestMethod . ' Method Not Allowed', "HTTP/1.0 405 Method Not Allowed");
}

?>
