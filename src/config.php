<?php
define('DB_HOST', 'db'); // Change 'localhost' to 'db' (Docker service name)
define('DB_USER', 'root');
define('DB_PASS', 'rootpassword'); // Set the password in docker-compose.yml
define('DB_NAME', 'vacation_db');

$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>
