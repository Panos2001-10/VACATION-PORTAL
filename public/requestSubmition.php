<?php
// Include necessary files for database connection, authentication check, and message handling
include __DIR__ . '/../src/config.php';  // Database connection configuration
include __DIR__ . '/../middleware/authCheck.php';  // To ensure the user is logged in
include __DIR__ . '/../middleware/messageHandler.php';  // For handling success/error messages

// Ensure the user is logged in by checking session variables
if (!isset($_SESSION['user_employee_code']) || !isset($_SESSION['user_full_name']) || !isset($_SESSION['user_manager_code'])) {
    addMessage("error", "You must be logged in to submit a request.");  // Add error message
    header("Location: index.php");  // Redirect to login page if user is not logged in
    exit();  // Exit the script to prevent further execution
}

// Get the logged-in user's information from the session
$employeeCode = $_SESSION['user_employee_code'];  // Employee code from session
$fullName = $_SESSION['user_full_name'];  // Full name from session
$managerCode = $_SESSION['user_manager_code'];  // Manager code from session
$startDate = $_POST['start_date'];  // Start date of the vacation request
$endDate = $_POST['end_date'];  // End date of the vacation request
$reason = $_POST['reason'];  // Reason for the vacation request
$submittedDate = date("Y-m-d H:i:s");  // Get the current date and time for when the request is submitted

// Validate that the start date is not after the end date
if (strtotime($startDate) > strtotime($endDate)) {
    addMessage("error", "Start date cannot be after the end date.");  // Add error message
    header("Location: requestSubmitionForm.php");  // Redirect back to the request submission form
    exit();  // Exit the script
}

// Prepare the SQL statement to insert the vacation request into the database
$stmt = $connection->prepare("
    INSERT INTO requests (employee_code, submitted_date, start_date, end_date, reason, status)
    VALUES (?, ?, ?, ?, ?, 'pending')
");
// Bind the parameters to the SQL statement
$stmt->bind_param("issss", $employeeCode, $submittedDate, $startDate, $endDate, $reason);

// Execute the SQL statement to insert the data
if ($stmt->execute()) {
    addMessage("success", "Vacation request submitted successfully!");  // Add success message if submission is successful
} else {
    addMessage("error", "An error occurred. Please try again.");  // Add error message if submission fails
}

// Redirect back to the vacation requests form after submitting
header("Location: vacationRequestsForm.php");
exit();  // Exit the script
?>
