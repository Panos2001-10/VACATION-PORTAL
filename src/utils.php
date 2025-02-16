<?php
// Function to generate the footer and prevent xss
function getLoggedInUserInfo() {
    if (!isset($_SESSION['user_full_name']) || !isset($_SESSION['user_role'])) {
        return "Guest (No role assigned)";
    }

    // Escape output to prevent XSS
    $fullName = htmlspecialchars($_SESSION['user_full_name'], ENT_QUOTES, 'UTF-8');
    $role = htmlspecialchars($_SESSION['user_role'], ENT_QUOTES, 'UTF-8');

    return "You are logged in as: " . $fullName . " (" . $role . ")";
}


// Function to calculate total weekdays between two dates
function countWeekdays($start_date, $end_date) {
    $start = new DateTime($start_date);
    $end = new DateTime($end_date);
    $interval = new DateInterval('P1D'); // 1-day interval
    $dateRange = new DatePeriod($start, $interval, $end->modify('+1 day')); // Include end date
    $weekdayCount = 0;

    foreach ($dateRange as $date) {
        if ($date->format('N') < 6) { // 1 (Monday) to 5 (Friday) are weekdays
            $weekdayCount++;
        }
    }

    return $weekdayCount;
}

// Function to delete expired vacation requests
function deleteExpiredRequests($connection) {
    // Delete rejected requests that are older than 2 days
    $stmt = $connection->prepare("DELETE FROM requests WHERE status = 'rejected' AND submitted_date <= NOW() - INTERVAL 2 DAY");
    $stmt->execute();

    // Delete approved requests that are past the end date
    $stmt = $connection->prepare("DELETE FROM requests WHERE status = 'approved' AND end_date < NOW()");
    $stmt->execute();
}

// Function to check if the logged-in manager can edit the employee
function checkManagerAuthorization($connection, $employeeCode) {
    // Ensure the session is started and the manager code is set
    if (!isset($_SESSION['user_manager_code'])) {
        return ['status' => false, 'message' => 'Manager is not logged in.'];
    }

    // Fetch the manager code for the employee being edited
    $stmt = $connection->prepare("SELECT manager_code FROM users WHERE employee_code = ?");
    $stmt->bind_param("i", $employeeCode);
    $stmt->execute();

    // Initialize $managerCodeResult to null before binding
    $managerCodeResult = null;
    
    // Bind the result to the $managerCodeResult variable
    $stmt->bind_result($managerCodeResult);
    
    // Check if the employee exists
    if (!$stmt->fetch()) {
        return false;  // Employee not found or result empty
    }

    // Check if the session manager code matches the employee's manager code
    if ($_SESSION['user_manager_code'] != $managerCodeResult) {
        return false;
    }

    return true;
}
?>