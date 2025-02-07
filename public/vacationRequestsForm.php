<?php
include __DIR__ . '/../src/config.php';
include __DIR__ . '/../middleware/messageHandler.php';
include __DIR__ . '/../middleware/authCheck.php';

// Fetch vacation requests for the logged-in user
$stmt = $connection->prepare("SELECT id, employee_id, start_date, end_date, reason, status FROM vacation_requests WHERE employee_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Redirect to login page
    exit();
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
    <table border="1">
        <tr>
            <th>Date Submitted</th>
            <th>Dates Requested</th>
            <th>Total Days</th>
            <th>Reason</th>
            <th>Status</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <!-- Date Submitted: Current Date -->
            <td><?php echo date('Y-m-d'); ?></td>

            <!-- Dates Requested: Start Date to End Date -->
            <td><?php echo htmlspecialchars($row['start_date']) . ' to ' . htmlspecialchars($row['end_date']); ?></td>

            <!-- Total Days: Calculate the difference between start and end dates -->
            <td>
                <?php 
                $startDate = new DateTime($row['start_date']);
                $endDate = new DateTime($row['end_date']);
                $interval = $startDate->diff($endDate);
                echo $interval->days . " days"; 
                ?>
            </td>

            <!-- Reason: Assuming 'reason' is a column in your table -->
            <td><?php echo htmlspecialchars($row['reason']); ?></td>

            <!-- Status -->
            <td><?php echo htmlspecialchars($row['status']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    
    <br>
    <div class="messages">
        <?php displayMessages(); ?>
    </div>

    <div class="logout">
        <p>You are logged in as: Employee</p>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
