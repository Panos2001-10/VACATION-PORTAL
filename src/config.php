<?php
// Database Configuration File

// Define database connection constants
define('DB_HOST', 'db'); // 'db' is the Docker service name for the database container
define('DB_USER', 'root'); // MySQL username
define('DB_PASS', 'rootpassword'); // MySQL password (set in docker-compose.yml)
define('DB_NAME', 'vacation_db'); // Name of the database

// Establish a connection to the MySQL database
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check if the connection was successful
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error); // Terminate script if connection fails
}
?>
