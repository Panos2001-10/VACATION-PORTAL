<?php
// Function to generate the footer and prevent XSS (Cross-Site Scripting)
// It returns the logged-in user's full name and role, if available, or defaults to "Guest" if not logged in.
function getLoggedInUserInfo() {
    // Check if session variables for full name and role are set (i.e., the user is logged in)
    if (!isset($_SESSION['user_full_name']) || !isset($_SESSION['user_role'])) {
        return "Guest (No role assigned)";  // Return default message if not logged in
    }

    // Escape output to prevent XSS (i.e., potential malicious content in user input)
    $fullName = htmlspecialchars($_SESSION['user_full_name'], ENT_QUOTES, 'UTF-8');
    $role = htmlspecialchars($_SESSION['user_role'], ENT_QUOTES, 'UTF-8');

    // Return a string indicating the user's name and role
    return "You are logged in as: " . $fullName . " (" . $role . ")";
}

// Function to calculate total weekdays (Monday to Friday) between two dates
// It returns the number of weekdays between the given start and end date
function countWeekdays($start_date, $end_date) {
    // Convert the start and end date strings to DateTime objects
    $start = new DateTime($start_date);
    $end = new DateTime($end_date);

    // Define the interval as 1 day
    $interval = new DateInterval('P1D'); 

    // Create a DatePeriod object that generates all days between the start and end dates (inclusive of end date)
    $dateRange = new DatePeriod($start, $interval, $end->modify('+1 day')); 

    // Initialize a counter for weekdays
    $weekdayCount = 0;

    // Iterate through all the dates in the date range
    foreach ($dateRange as $date) {
        // Check if the current day is a weekday (Monday to Friday)
        if ($date->format('N') < 6) { // 'N' returns 1 for Monday, 2 for Tuesday, ..., 7 for Sunday
            $weekdayCount++;  // Increment the weekday counter
        }
    }

    // Return the total number of weekdays
    return $weekdayCount;
}

// Function to delete expired vacation requests from the database
// It deletes requests that are rejected for more than 2 days and approved requests that are past the end date
function deleteExpiredRequests($connection) {
    // Delete rejected vacation requests that were submitted more than 2 days ago
    $stmt = $connection->prepare("DELETE FROM requests WHERE status = 'rejected' AND submitted_date <= NOW() - INTERVAL 2 DAY");
    $stmt->execute();  // Execute the delete statement

    // Delete approved vacation requests that have passed their end date
    $stmt = $connection->prepare("DELETE FROM requests WHERE status = 'approved' AND end_date < NOW()");
    $stmt->execute();  // Execute the delete statement
}

// Function to check if the logged-in manager can edit the details of a specific employee
// It compares the manager's code in the session with the employee's manager code from the database
function checkManagerAuthorization($connection, $employeeCode) {
    // Ensure the session is started and the manager code is set in the session
    if (!isset($_SESSION['user_manager_code'])) {
        return ['status' => false, 'message' => 'Manager is not logged in.'];  // Return error if no manager code in session
    }

    // Prepare a statement to fetch the manager code associated with the given employee code from the database
    $stmt = $connection->prepare("SELECT manager_code FROM users WHERE employee_code = ?");
    $stmt->bind_param("i", $employeeCode);  // Bind the employee code parameter
    $stmt->execute();  // Execute the query

    // Initialize the variable to hold the manager code result
    $managerCodeResult = null;
    
    // Bind the fetched manager code to the result variable
    $stmt->bind_result($managerCodeResult);
    
    // Fetch the result and check if employee exists
    if (!$stmt->fetch()) {
        return false;  // Employee not found or no result returned
    }

    // Check if the session manager code matches the employee's manager code from the database
    if ($_SESSION['user_manager_code'] != $managerCodeResult) {
        return false;  // If manager codes don't match, return false
    }

    return true;  // Return true if the manager is authorized to edit the employee's details
}
?>
