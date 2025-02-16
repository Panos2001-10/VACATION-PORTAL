<?php
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
    // Get current date
    $currentDate = date("Y-m-d H:i:s");

    // Delete rejected requests that are older than 2 days
    $stmt = $connection->prepare("DELETE FROM requests WHERE status = 'rejected' AND submitted_date <= NOW() - INTERVAL 2 DAY");
    $stmt->execute();

    // Delete approved requests that are past the end date
    $stmt = $connection->prepare("DELETE FROM requests WHERE status = 'approved' AND end_date < NOW()");
    $stmt->execute();
}
?>
