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
?>
