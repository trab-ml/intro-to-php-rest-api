<?php
// required config before DB operations

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'rest-api');
define('QUERY_ERR_MESSAGE', "An error occurred while processing your request. Please try again later.");

define('INTERNAL_SERVER_ERR_MSG', "Internal Server Error. Please try again later.");
define('INTERNAL_SERVER_HEADER_ERR_MSG', "HTTP/1.0 500 Internal Server Error.");
define('UNPROCESSABLE_ENTITY_HEADER_ERR_MSG', "HTTP/1.0 422 Unprocessable Entity.");
define('HEADER_SUCCESS_MSG', "HTTP/1.0 200 Success.");

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (!$conn) {
    die('An error occured while connecting to the DB !' . mysqli_connect_error());
}
?>