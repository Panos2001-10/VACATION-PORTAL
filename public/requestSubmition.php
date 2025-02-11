<?php
include __DIR__ . '/../src/config.php';
include __DIR__ . '/../middleware/authCheck.php';
include __DIR__ . '/../middleware/messageHandler.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_employee_code']) || !isset($_SESSION['user_full_name'])) {
    addMessage("error", "You must be logged in to submit a request.");
    header("Location: index.php");
    exit();
}

// Get user inputs
$employeeCode = $_SESSION['user_employee_code'];
$fullName = $_SESSION['user_full_name'];
$startDate = $_POST['start_date'];
$endDate = $_POST['end_date'];
$reason = $_POST['reason'];

// Validate dates
if (strtotime($startDate) > strtotime($endDate)) {
    addMessage("error", "Start date cannot be after the end date.");
    header("Location: requestSubmitionForm.php");
    exit();
}

// Insert the vacation request into the database
$stmt = $connection->prepare("INSERT INTO requests (employee_code, full_name, start_date, end_date, reason, status) VALUES (?, ?, ?, ?, ?, 'pending')");
$stmt->bind_param("issss", $employeeCode, $fullName, $startDate, $endDate, $reason);

if ($stmt->execute()) {
    addMessage("success", "Vacation request submitted successfully!");
} else {
    addMessage("error", "An error occurred. Please try again.");
}

// Redirect back to the form or another page
header("Location: requestSubmitionForm.php");
exit();
?>
