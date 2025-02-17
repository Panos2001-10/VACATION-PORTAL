<?php
// Include necessary files for database connection, message handling, and authentication checks
include __DIR__ . '/../src/config.php';  // For database connection
include __DIR__ . '/../middleware/messageHandler.php';  // For adding messages
include __DIR__ . '/../middleware/authCheck.php';  // For authentication checks

// Retrieve request ID and action from the URL (query parameters)
$request_id = $_GET['id'] ?? null;  // ID of the request
$new_status = $_GET['action'] ?? null;  // New status for the request (e.g., approved or rejected)

// Check if both request ID and action are set in the URL
if (!isset($request_id) || !isset($new_status)) {
    addMessage("error", "Missing parameters.");  // If missing, display an error message
    header("Location: manageUsersForm.php");  // Redirect to the "manage users" form page
    exit();
}

// Get the employee code associated with the request from the 'requests' table
$stmt = $connection->prepare("SELECT employee_code FROM requests WHERE id = ?");
$stmt->bind_param("i", $request_id);  // Bind the request ID to the prepared statement
$stmt->execute();  // Execute the query
$stmt->bind_result($employee_code);  // Bind the result to the $employee_code variable
$stmt->fetch();  // Fetch the result into the $employee_code variable
$stmt->close();  // Close the statement

// If no employee code was found for the given request ID, prevent unauthorized access
if (!$employee_code) {
    addMessage("error", "Request not found.");  // Display an error if the request ID doesn't exist
    header("Location: manageUsersForm.php");  // Redirect to the "manage users" form page
    exit();
}

// Get the manager code of the employee from the 'users' table
$stmt = $connection->prepare("SELECT manager_code FROM users WHERE employee_code = ?");
$stmt->bind_param("i", $employee_code);  // Bind the employee code to the prepared statement
$stmt->execute();  // Execute the query to fetch the manager code
$stmt->bind_result($request_manager_code);  // Bind the result to the $request_manager_code variable
$stmt->fetch();  // Fetch the manager code for the employee
$stmt->close();  // Close the statement

// Check if the logged-in manager is authorized to update the request's status
if (!$request_manager_code || $_SESSION['user_manager_code'] != $request_manager_code) {
    addMessage("error", "Unauthorized action.");  // Display an error if the logged-in manager is not authorized
    header("Location: manageUsersForm.php");  // Redirect to the "manage users" form page
    exit();
}

// Proceed with updating the request's status (approved, rejected, etc.)
$stmt = $connection->prepare("UPDATE requests SET status = ? WHERE id = ?");
$stmt->bind_param("si", $new_status, $request_id);  // Bind the new status and request ID to the prepared statement

// Execute the update query
if ($stmt->execute()) {
    addMessage("success", "Request has been " . $new_status . ".");  // Display a success message if the update is successful
} else {
    addMessage("error", "Failed to update request.");  // Display an error message if the update fails
}

// Redirect back to the "manage users" form page
header("Location: manageUsersForm.php");
exit();
?>
