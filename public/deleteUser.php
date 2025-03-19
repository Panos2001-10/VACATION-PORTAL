<?php
require_once __DIR__ . '/../src/bootstrap.php';

use App\classes\messageHandler;
use App\classes\database;

$database = new database();

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    // Check if 'id' is set and contains only digits (prevents SQL injection)
    messageHandler::addMessage("error", "Invalid request."); // Add an error message
    header("Location: manageUsersForm.php");
    exit();
}

// Convert the ID to an integer for added security
$employeeCode = (int) $_GET['id']; 

// Ensure the logged-in manager has permission to delete this employee
if (!checkManagerAuthorization($database->getConnection(), $employeeCode)) {
    messageHandler::addMessage("error", "You are not authorized to delete this employee.");
    header("Location: manageUsersForm.php");
    exit();
}

$stmt = $database->getConnection()->prepare("DELETE FROM users WHERE employee_code = ?");
$stmt->bind_param("i", $employeeCode);


if ($stmt->execute()) {
    messageHandler::addMessage("success", "user deleted successfully."); // Success message
} else {
    messageHandler::addMessage("error", "Error deleting user: " . $stmt->error); // Error message with details
}

header("Location: manageUsersForm.php");
exit();

