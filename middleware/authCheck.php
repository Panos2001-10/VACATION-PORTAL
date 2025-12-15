<?php
session_start();

// Redirect to login if user is not authenticated and not already on the login page
if ((!isset($_SESSION["user_manager_code"]) || !isset($_SESSION["user_employee_code"])) && basename($_SERVER['PHP_SELF']) !== 'index.php') {
    header("Location: index.php");
    exit();
}
?>
