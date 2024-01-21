<?php

require_once '../config.php';

/**
 * Create a JSON response.
 *
 * @param int $statusCode HTTP status code
 * @param string $message Response message
 * @param string $msgToHeader HTTP response header
 * @return string JSON response
 */
function createResponse($statusCode, $message, $msgToHeader) {
    http_response_code($statusCode);
    header($msgToHeader);
    $data = [
        'status' => $statusCode,
        'message' => $message,
    ];
    return json_encode($data);
}

/**
 * Create a JSON success response with data.
 *
 * @param int $statusCode HTTP status code
 * @param string $message Response message
 * @param array $res Data to include in the response
 * @param string $msgToHeader HTTP response header
 * @return string JSON response
 */
function successResponse($statusCode, $message, $res, $msgToHeader) {
    http_response_code($statusCode);
    header($msgToHeader);
    $data = [
        'status' => $statusCode,
        'message' => $message,
        'data' => $res,
    ];
    return json_encode($data);
}

/**
 * Retrieve a specific customer.
 *
 * @return string JSON response
 */
function getCustomer($conn, $customerParams)
{

    if ($customerParams['id'] == null) {
        return error422('Enter your customer ID');
    }

    $customerId = mysqli_real_escape_string($conn, $customerParams['id']);

    $query = "SELECT * FROM customers WHERE id='$customerId' LIMIT 1";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $customerId);

    if ($result = mysqli_query($conn, $query)) {
        if (mysqli_num_rows($result) == 1) {
            $res = mysqli_fetch_all($result, MYSQLI_ASSOC);

            return successResponse(200, 'Customer Fetched Successfully', $res, HEADER_SUCCESS_MSG);

        } else {
            return createResponse(500, 'No Customer Found', "HTTP/1.0 404 Not Found");
        }
    } else {
        return createResponse(500, INTERNAL_SERVER_ERR_MSG, INTERNAL_SERVER_HEADER_ERR_MSG);
    }
}

/**
 * Retrieve a list of customers.
 *
 * @return string JSON response
 */
function getCustomerList($conn) {
    global $conn;

    $query = "SELECT * FROM customers";
    $stmt = mysqli_prepare($conn, $query);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return successResponse(200, 'Customer Fetched Successfully', $res, HEADER_SUCCESS_MSG);
        } else {
            return createResponse(404, "No Customer Found", "HTTP/1.0 404 No Customer Found");
        }
    } else {
        return createResponse(500, INTERNAL_SERVER_ERR_MSG, INTERNAL_SERVER_HEADER_ERR_MSG);
    }
}

/**
 * Handle error with status code 422.
 *
 * @param string $errMsg Error message
 * @return string JSON response
 */
function error422($errMsg) {
    return createResponse(422, $errMsg, UNPROCESSABLE_ENTITY_HEADER_ERR_MSG);
}

/**
 * Store a new customer in the database.
 *
 * @param array $customerInput Customer input data
 * @return string JSON response
 */
function storeCustomer($conn, $customerInput) {
    $name = mysqli_real_escape_string($conn, $customerInput['name']);
    $email = mysqli_real_escape_string($conn, $customerInput['email']);
    $phone = mysqli_real_escape_string($conn, $customerInput['phone']);

    if (empty(trim($name)) || empty(trim($email)) || empty(trim($phone))) {
        return error422('Enter your name, email, and phone');
    } else {
        $query = "INSERT INTO customers (name, email, phone) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $phone);

        if (mysqli_stmt_execute($stmt)) {
            return createResponse(201, 'Customer Created Successfully', "HTTP/1.0 201 Success");
        } else {
            return createResponse(500, INTERNAL_SERVER_ERR_MSG, INTERNAL_SERVER_HEADER_ERR_MSG);
        }
    }
}

/**
 * Update customer data in the database.
 *
 * @param mysqli $conn Database connection
 * @param array $customerInput Updated customer data
 * @param array $customerParams Additional parameters
 * @return string JSON response
 */
function updateCustomer($conn, $customerInput, $customerParams) {
    if (empty($customerParams['id'])) {
        return createResponse(422, 'Customer ID not found or empty', UNPROCESSABLE_ENTITY_HEADER_ERR_MSG);
    }

    $customerId = mysqli_real_escape_string($conn, $customerParams['id']);
    $name = trim(mysqli_real_escape_string($conn, $customerInput['name']));
    $email = trim(mysqli_real_escape_string($conn, $customerInput['email']));
    $phone = trim(mysqli_real_escape_string($conn, $customerInput['phone']));

    if (empty($name) || empty($email) || empty($phone)) {
        return createResponse(422, 'Name, email, and phone are required', UNPROCESSABLE_ENTITY_HEADER_ERR_MSG);
    }

    $query = "UPDATE customers SET name=?, email=?, phone=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $phone, $customerId);
    
    if (mysqli_stmt_execute($stmt)) {
        return createResponse(200, 'Customer Updated Successfully', HEADER_SUCCESS_MSG);
    } else {
        return createResponse(500, INTERNAL_SERVER_ERR_MSG, INTERNAL_SERVER_HEADER_ERR_MSG);
    }
}

function deleteCustomer($conn, $customerParams)
{

    $customerId = mysqli_real_escape_string($conn, $customerParams['id']);

    if (empty(trim($customerId))) {
        return error422('Customer ID Not Found.');
    } else {
        $query = "DELETE FROM customers WHERE id=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $customerId);

        if (mysqli_stmt_execute($stmt)) {
            return createResponse(200, 'Customer Deleted Successfully', HEADER_SUCCESS_MSG);
        } else {
            return createResponse(500, INTERNAL_SERVER_ERR_MSG, INTERNAL_SERVER_HEADER_ERR_MSG);
        }
    }
}
