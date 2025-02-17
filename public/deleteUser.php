<?php
// Include necessary files for database connection, utility functions, and authentication
include __DIR__ . '/../src/config.php'; // Database connection settings
include __DIR__ . '/../src/utils.php'; // Utility functions (e.g., authorization check)
include __DIR__ . '/../middleware/messageHandler.php'; // Handles success/error messages
include __DIR__ . '/../middleware/authCheck.php'; // Ensures the user is authenticated

// Validate and sanitize the user ID from the URL parameter
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) { 
    // Check if 'id' is set and contains only digits (prevents SQL injection)
    addMessage("error", "Invalid request."); // Add an error message
    header("Location: manageUsersForm.php"); // Redirect back to the user management page
    exit(); // Stop further execution
}

// Convert the ID to an integer for added security
$employeeCode = (int) $_GET['id']; 

// Ensure the logged-in manager has permission to delete this employee
if (!checkManagerAuthorization($connection, $employeeCode)) {
    addMessage("error", "You are not authorized to delete this employee.");
    header("Location: manageUsersForm.php"); // Redirect to the user management page
    exit(); // Stop script execution
}

// Prepare the DELETE query using a prepared statement to prevent SQL injection
$stmt = $connection->prepare("DELETE FROM users WHERE employee_code = ?");
$stmt->bind_param("i", $employeeCode); // Bind the employee ID as an integer parameter

// Execute the query and check if the deletion was successful
if ($stmt->execute()) {
    addMessage("success", "User deleted successfully."); // Success message
} else {
    addMessage("error", "Error deleting user: " . $stmt->error); // Error message with details
}

// Redirect back to the user management page after deletion
header("Location: manageUsersForm.php");
exit(); // Stop further execution
?>
