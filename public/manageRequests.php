<?php
require_once __DIR__ . '/../src/bootstrap.php';

use App\classes\messageHandler;
use App\classes\database;

$database = new database();
$request_id = $_GET['id'] ?? null;  // ID of the request
$new_status = $_GET['action'] ?? null;  // New status for the request (e.g., approved or rejected)

// Check if both request ID and action are set in the URL
if (!isset($request_id) || !isset($new_status)) {
    messageHandler::addMessage("error", "Missing parameters.");
    header("Location: manageUsersForm.php");
    exit();
}


$stmt = $database->getConnection()->prepare("SELECT employee_code FROM requests WHERE id = ?");
$stmt->bind_param("i", $request_id);
$stmt->execute();
$stmt->bind_result($employee_code);
$stmt->fetch();
$stmt->close();


if (!$employee_code) {
    messageHandler::addMessage("error", "Request not found.");
    header("Location: manageUsersForm.php");
    exit();
}

$stmt = $database->getConnection()->prepare("SELECT manager_code FROM users WHERE employee_code = ?");
$stmt->bind_param("i", $employee_code);
$stmt->execute();
$stmt->bind_result($request_manager_code);
$stmt->fetch();
$stmt->close();

// Check if the logged-in manager is authorized to update the request's status
if (!$request_manager_code || $_SESSION['user_manager_code'] != $request_manager_code) {
    messageHandler::addMessage("error", "Unauthorized action.");
    header("Location: manageUsersForm.php");
    exit();
}

// Proceed with updating the request's status (approved, rejected, etc.)
$stmt = $database->getConnection()->prepare("UPDATE requests SET status = ? WHERE id = ?");
$stmt->bind_param("si", $new_status, $request_id);

// Execute the update query
if ($stmt->execute()) {
    messageHandler::addMessage("success", "Request has been " . $new_status . ".");
} else {
    messageHandler::addMessage("error", "Failed to update request.");
}

header("Location: manageUsersForm.php");
exit();

