<?php
// Start the session to access session variables
session_start();

// Check if the user is NOT logged in (i.e., if 'user_manager_code' and 'user_employee_code' are not set)
// AND if the current page is NOT 'index.php' (the login page)
if ((!isset($_SESSION["user_manager_code"]) || !isset($_SESSION["user_employee_code"])) && basename($_SERVER['PHP_SELF']) !== 'index.php') {
    // If the user is not logged in and they are not on the login page, redirect them to 'index.php' (the login page)
    header("Location: index.php");
    // Stop the script from executing further
    exit();
}
?>
