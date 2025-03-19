<?php
require_once __DIR__ . '/../src/bootstrap.php';

use App\classes\messageHandler;
use App\classes\database;

$database = new database();

if (!isset($_SESSION['user_employee_code']) || !isset($_SESSION['user_full_name']) || !isset($_SESSION['user_manager_code'])) {
    messageHandler::addMessage("error", "You must be logged in to submit a request.");
    header("Location: index.php");
    exit();
}

// Get the logged-in user's information from the session
$employeeCode = $_SESSION['user_employee_code'];
$fullName = $_SESSION['user_full_name'];
$managerCode = $_SESSION['user_manager_code'];
$startDate = $_POST['start_date'];
$endDate = $_POST['end_date'];
$reason = $_POST['reason'];
$submittedDate = date("Y-m-d H:i:s");

// Validate that the start date is not after the end date
if (strtotime($startDate) > strtotime($endDate)) {
    messageHandler::addMessage("error", "Start date cannot be after the end date.");
    header("Location: requestSubmitionForm.php");
    exit();
}

// Prepare the SQL statement to insert the vacation request into the database
$stmt = $database->getConnection()->prepare("
    INSERT INTO requests (employee_code, submitted_date, start_date, end_date, reason, status)
    VALUES (?, ?, ?, ?, ?, 'pending')
");
// Bind the parameters to the SQL statement
$stmt->bind_param("issss", $employeeCode, $submittedDate, $startDate, $endDate, $reason);

// Execute the SQL statement to insert the data
if ($stmt->execute()) {
    messageHandler::addMessage("success", "Vacation request submitted successfully!");
} else {
    messageHandler::addMessage("error", "An error occurred. Please try again.");
}

// Redirect back to the vacation requests form after submitting
header("Location: vacationRequestsForm.php");
exit();
