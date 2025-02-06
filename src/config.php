<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Change if needed
define('DB_PASS', ''); // Change if needed
define('DB_NAME', 'vacation_db');

$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check if the connection was successful
if ($connection->connect_error)
{
    $_SESSION['db_message'] = "❌ Connection failed: " . $connection->connect_error;
} 
else
{
    $_SESSION['db_message'] = "✅ Connected successfully to the database!";
}
?>