<?php
include __DIR__ . '/../src/config.php';
include __DIR__ . '/../middleware/messageHandler.php';
include __DIR__ . '/../middleware/authCheck.php';


// Validate and sanitize the user ID
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    addMessage("error", "Invalid request.");
    header("Location: manageUsersForm.php");
    exit();
}

$employee_id = (int) $_GET['id']; // Cast to integer for safety

// Prepare and execute the delete query
$stmt = $connection->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $employee_id);

if ($stmt->execute()) {
    addMessage("success", "User deleted successfully.");
} else {
    addMessage("error", "Error deleting user: " . $stmt->error);
}

header("Location: manageUsersForm.php");
exit();
?>
