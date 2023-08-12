<?php

require '../config.php';

function getCustomerList()
{
    global $conn;

    $query = "SELECT * FROM customers";
    $queryRun = mysqli_query($conn, $query);

    if ($queryRun) {

        if (mysqli_num_rows($queryRun) > 0) {
            $res = mysqli_fetch_all($queryRun, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'Customer List Fetched Sucessfully',
                'data' => $res,
            ];
            header("HTTP/1.0 200 OK");
            echo json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No Customer Found',
            ];
            header("HTTP/1.0 404 No Customer Found");
            echo json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => INTERNAL_SERVER_ERR_MSG,
        ];
        header(INTERNAL_SERVER_HEADER_ERR_MSG);
        echo json_encode($data);
    }
}

function error422($errMsg)
{
    $data = [
        'status' => 422,
        'message' => $errMsg,
    ];
    header("HTTP/1.0 422 Unprocessable Entity");
    echo json_encode($data);
}

function storeCustomer($customerInput)
{
    global $conn;

    $name = mysqli_real_escape_string($conn, $customerInput['name']);
    $email = mysqli_real_escape_string($conn, $customerInput['email']);
    $phone = mysqli_real_escape_string($conn, $customerInput['phone']);

    if (empty(trim($name))) {
        error422('Enter your name');
    } elseif (empty(trim($email))) {
        error422('Enter your email');
    } elseif (empty(trim($phone))) {
        error422('Enter your phone');
    } else {
        $query = "INSERT INTO customers (name, email, phone) VALUES ('$name', '$email', '$phone')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $data = [
                'status' => 201,
                'message' => 'Customer Created Sucessfully',
            ];
            header("HTTP/1.0 201 Created");
            echo json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => INTERNAL_SERVER_ERR_MSG,
            ];
            header(INTERNAL_SERVER_HEADER_ERR_MSG);
            echo json_encode($data);
        }
    }
}

function getCustomer($customerParams)
{
    global $conn;

    if ($customerParams['id'] == null) {
        error422('Enter your customer ID');
    }

    $customerId = mysqli_real_escape_string($conn, $customerParams['id']);

    $query = "SELECT * FROM customers WHERE id='$customerId' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $res = mysqli_fetch_all($result, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'Customer Fetched Sucessfully',
                'data' => $res,
            ];
            header("HTTP/1.0 200 Success");
            echo json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No Customer Found',
            ];
            header("HTTP/1.0 404 Not Found");
            echo json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => INTERNAL_SERVER_ERR_MSG,
        ];
        header(INTERNAL_SERVER_HEADER_ERR_MSG);
        echo json_encode($data);
    }
}

function deleteCustomer($customerParams)
{
    global $conn;

    $customerId = mysqli_real_escape_string($conn, $customerParams['id']);
    $confirm = mysqli_real_escape_string($conn, $customerParams['confirmDeletion']);

    if (empty(trim($customerId))) {
        error422('Enter the ID of the customer to delete.');
    } elseif (empty(trim($confirm))) {
        error422('Confirm the deletion.');
    } else {
        $query = "DELETE FROM customers WHERE id='$customerId'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $data = [
                'status' => 200,
                'message' => 'Customer Deleted Sucessfully',
            ];
            header("HTTP/1.0 200 Deleted");
            echo json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => INTERNAL_SERVER_ERR_MSG,
            ];
            header(INTERNAL_SERVER_HEADER_ERR_MSG);
            echo json_encode($data);
        }
    }
}
