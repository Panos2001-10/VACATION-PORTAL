<?php
// Function to generate the footer and prevent XSS (Cross-Site Scripting)
// It returns the logged-in user's full name and role, if available, or defaults to "Guest" if not logged in.
function getLoggedInUserInfo() {
    if (!isset($_SESSION['user_full_name']) || !isset($_SESSION['user_role'])) {
        return "Guest (No role assigned)";
    }

    $fullName = htmlspecialchars($_SESSION['user_full_name'], ENT_QUOTES, 'UTF-8');
    $role = htmlspecialchars($_SESSION['user_role'], ENT_QUOTES, 'UTF-8');

    return "You are logged in as: " . $fullName . " (" . $role . ")";
}

// Function to calculate total weekdays (Monday to Friday) between two dates
// It returns the number of weekdays between the given start and end date
function countWeekdays($start_date, $end_date) {
    $start = new DateTime($start_date);
    $end = new DateTime($end_date);

    $interval = new DateInterval('P1D'); 
    $dateRange = new DatePeriod($start, $interval, $end->modify('+1 day')); 

    $weekdayCount = 0;

    foreach ($dateRange as $date) {
        if ($date->format('N') < 6) {
            $weekdayCount++;
        }
    }

    return $weekdayCount;
}

// Function to delete expired vacation requests from the database
// It deletes requests that are rejected for more than 2 days and approved requests that are past the end date
function deleteExpiredRequests($connection) {
    $stmt = $connection->prepare("DELETE FROM requests WHERE status = 'rejected' AND submitted_date <= NOW() - INTERVAL 2 DAY");
    $stmt->execute();

    $stmt = $connection->prepare("DELETE FROM requests WHERE status = 'approved' AND end_date < NOW()");
    $stmt->execute();
}

// Function to check if the logged-in manager can edit the details of a specific employee
// It compares the manager's code in the session with the employee's manager code from the database
function checkManagerAuthorization($connection, $employeeCode) {
    if (!isset($_SESSION['user_manager_code'])) {
        return ['status' => false, 'message' => 'Manager is not logged in.'];
    }

    $stmt = $connection->prepare("SELECT manager_code FROM users WHERE employee_code = ?");
    $stmt->bind_param("i", $employeeCode);
    $stmt->execute();

    $managerCodeResult = null;
    $stmt->bind_result($managerCodeResult);
    
    if (!$stmt->fetch()) {
        return false;
    }

    if ($_SESSION['user_manager_code'] != $managerCodeResult) {
        return false;
    }

    return true;
}
?>
