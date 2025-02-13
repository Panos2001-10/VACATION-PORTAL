<?php
// Start the session
session_start();

// Check if the user is NOT logged in AND the current page is NOT index.php
if ((!isset($_SESSION["user_manager_code"]) || !isset($_SESSION["user_employee_code"])) && basename($_SERVER['PHP_SELF']) !== 'index.php') {
    // Redirect to the login page (index.php)
    header("Location: index.php");
    exit();
}
?>
