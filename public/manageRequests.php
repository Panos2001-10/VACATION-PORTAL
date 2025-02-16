<?php
include __DIR__ . '/../src/config.php';
include __DIR__ . '/../middleware/messageHandler.php';
include __DIR__ . '/../middleware/authCheck.php';

// Get request ID and action
$request_id = $_GET['id'] ?? null;
$new_status = $_GET['action'] ?? null;

if (!isset($request_id) || !isset($new_status)) {
    addMessage("error", "Missing parameters.");
    header("Location: manageUsersForm.php");
    exit();
}

// Get the employee_code associated with the request
$stmt = $connection->prepare("SELECT employee_code FROM requests WHERE id = ?");
$stmt->bind_param("i", $request_id);
$stmt->execute();
$stmt->bind_result($employee_code);
$stmt->fetch();
$stmt->close();

// If request is not found, prevent unauthorized access
if (!$employee_code) {
    addMessage("error", "Request not found.");
    header("Location: manageUsersForm.php");
    exit();
}

// Get the manager_code of the employee from the users table
$stmt = $connection->prepare("SELECT manager_code FROM users WHERE employee_code = ?");
$stmt->bind_param("i", $employee_code);
$stmt->execute();
$stmt->bind_result($request_manager_code);
$stmt->fetch();
$stmt->close();

// Check if the logged-in manager is authorized
if (!$request_manager_code || $_SESSION['user_manager_code'] != $request_manager_code) {
    addMessage("error", "Unauthorized action.");
    header("Location: manageUsersForm.php");
    exit();
}

// Proceed with updating the request status
$stmt = $connection->prepare("UPDATE requests SET status = ? WHERE id = ?");
$stmt->bind_param("si", $new_status, $request_id);

if ($stmt->execute()) {
    addMessage("success", "Request has been " . $new_status . ".");
} else {
    addMessage("error", "Failed to update request.");
}

header("Location: manageUsersForm.php");
exit();
?>
