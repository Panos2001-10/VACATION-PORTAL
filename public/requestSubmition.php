<?php
include __DIR__ . '/../src/config.php';
include __DIR__ . '/../middleware/authCheck.php';
include __DIR__ . '/../middleware/messageHandler.php';

if (!isset($_SESSION['user_employee_code']) || !isset($_SESSION['user_full_name']) || !isset($_SESSION['user_manager_code'])) {
    addMessage("error", "You must be logged in to submit a request.");
    header("Location: index.php");
    exit();
}

$employeeCode = $_SESSION['user_employee_code'];
$fullName = $_SESSION['user_full_name'];
$managerCode = $_SESSION['user_manager_code'];
$startDate = $_POST['start_date'];
$endDate = $_POST['end_date'];
$reason = $_POST['reason'];
$submittedDate = date("Y-m-d H:i:s");

if (strtotime($startDate) > strtotime($endDate)) {
    addMessage("error", "Start date cannot be after the end date.");
    header("Location: requestSubmitionForm.php");
    exit();
}

$stmt = $connection->prepare("
    INSERT INTO requests (employee_code, submitted_date, start_date, end_date, reason, status)
    VALUES (?, ?, ?, ?, ?, 'pending')
");
$stmt->bind_param("issss", $employeeCode, $submittedDate, $startDate, $endDate, $reason);

if ($stmt->execute()) {
    addMessage("success", "Vacation request submitted successfully!");
} else {
    addMessage("error", "An error occurred. Please try again.");
}

header("Location: vacationRequestsForm.php");
exit();
?>
