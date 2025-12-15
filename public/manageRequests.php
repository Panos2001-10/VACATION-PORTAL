<?php
include __DIR__ . '/../src/config.php';
include __DIR__ . '/../middleware/messageHandler.php';
include __DIR__ . '/../middleware/authCheck.php';

$request_id = $_GET['id'] ?? null;
$new_status = $_GET['action'] ?? null;

if (!isset($request_id) || !isset($new_status)) {
    addMessage("error", "Missing parameters.");
    header("Location: manageUsersForm.php");
    exit();
}

$stmt = $connection->prepare("SELECT employee_code FROM requests WHERE id = ?");
$stmt->bind_param("i", $request_id);
$stmt->execute();
$stmt->bind_result($employee_code);
$stmt->fetch();
$stmt->close();

if (!$employee_code) {
    addMessage("error", "Request not found.");
    header("Location: manageUsersForm.php");
    exit();
}

$stmt = $connection->prepare("SELECT manager_code FROM users WHERE employee_code = ?");
$stmt->bind_param("i", $employee_code);
$stmt->execute();
$stmt->bind_result($request_manager_code);
$stmt->fetch();
$stmt->close();

if (!$request_manager_code || $_SESSION['user_manager_code'] != $request_manager_code) {
    addMessage("error", "Unauthorized action.");
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
