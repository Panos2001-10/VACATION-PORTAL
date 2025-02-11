<?php
// If user is not logged in, redirect to login page
session_start();

// Check if the user is NOT logged in AND the current page is NOT index.php
if (!isset($_SESSION["user_employee_code"]) && basename($_SERVER['PHP_SELF']) !== 'index.php') {
    header("Location: index.php");
    exit();
}

// Role-based access control (if the page is for managers only)
$managerOnlyPages = ['manageUsersForm.php', 'manageRequestsForm.php', 'manageRequests.php', 'createUserForm.php', 'createUser.php', 'editUserForm.php', 'editUser.php', 'deleteUser.php'];
$currentPage = basename($_SERVER['PHP_SELF']);

if (in_array($currentPage, $managerOnlyPages) && $_SESSION['user_role'] !== 'manager') {
    header("Location: vacationRequestsForm.php"); // Redirect employees to their page
    exit();
}
?>
