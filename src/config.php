<?php

define('DB_HOST', 'db');
define('DB_USER', 'root');
define('DB_PASS', 'rootpassword');
define('DB_NAME', 'vacation_db');

$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>
