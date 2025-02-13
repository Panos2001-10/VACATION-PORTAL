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