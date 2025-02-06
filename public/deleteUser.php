<?php
session_start();
include __DIR__ . '/../src/config.php';

// Check if the user is logged in and is a manager
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "manager") {
    header("Location: index.php");
    exit();
}

// Check if an ID is provided
if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$employee_id = $_GET['id'];

// Prepare and execute the delete query
$stmt = $connection->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $employee_id);

if ($stmt->execute()) {
    echo "User deleted successfully!";
} else {
    echo "Error deleting record: " . $stmt->error;
}
exit();
?>