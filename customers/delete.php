<?php

header('Access-Control-Allow-Origin');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Content-type, Access-Control-Allow-Headers, Authorization, X-request-With');

include "function.php";

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == "POST") {
    if (isset($_POST['id'])) {
        $customer = deleteCustomer($_POST);
        echo $customer;
    } 

} else {
    $data = [
        'status' => 405,
        'message' => $requestMethod . ' Method Not Allowed',
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}
