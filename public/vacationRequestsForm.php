<?php
include __DIR__ . '/../src/config.php';
include __DIR__ . '/../middleware/messageHandler.php';
include __DIR__ . '/../middleware/authCheck.php';

// Ensure user is logged in
if (!isset($_SESSION['user_employee_code'])) {
    addMessage('error', 'Something went wrong. Please try again!');
    header('Location: index.php'); // Redirect to login page
    exit();
}

// Fetch vacation requests for the logged-in user
$stmt = $connection->prepare("SELECT id, employee_code, start_date, end_date, reason, status FROM requests WHERE employee_code = ?");
$stmt->bind_param("i", $_SESSION['user_employee_code']);
$stmt->execute();
$result = $stmt->get_result();

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vacation Requests</title>
</head>
<body>
    <h2>List of Vacation Requests</h2>

    <a href="requestSubmitionForm.php">Submit new request</a>
    <br><br>

    <table border="1">
        <tr>
            <th>Date Submitted</th>
            <th>Dates Requested</th>
            <th>Total Days (Weekdays only)</th>
            <th>Reason</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <!-- Date Submitted: Current Date -->
            <td><?php echo date('Y-m-d'); ?></td>

            <!-- Dates Requested: Start Date to End Date -->
            <td><?php echo htmlspecialchars($row['start_date']) . ' to ' . htmlspecialchars($row['end_date']); ?></td>

            <!-- Total Days (Weekdays only) -->
            <td><?php echo countWeekdays($row['start_date'], $row['end_date']) . " days"; ?></td>

            <!-- Reason -->
            <td><?php echo htmlspecialchars($row['reason']); ?></td>

            <!-- Status -->
            <td><?php echo htmlspecialchars($row['status']); ?></td>

            <!-- Delete Option (Only if status is 'pending') -->
            <td>
                <?php if ($row['status'] === 'pending'): ?>
                    <a href="deleteRequest.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this request?');">Delete</a>
                <?php else: ?>
                    N/A
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    
    <br>
    <div class="messages">
        <?php displayMessages(); ?>
    </div>
    
    <br>
    <div class="logout">
        <p>You are logged in as: <?php echo $_SESSION['user_full_name'] . ", " . $_SESSION['user_role']; ?></p>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
