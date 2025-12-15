<?php
include __DIR__ . '/../src/config.php';
include __DIR__ . '/../src/utils.php';
include __DIR__ . '/../middleware/messageHandler.php';
include __DIR__ . '/../middleware/authCheck.php';

$stmt = $connection->prepare("SELECT id, employee_code, start_date, end_date, reason, status, submitted_date FROM requests WHERE employee_code = ?");
$stmt->bind_param("i", $_SESSION['user_employee_code']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vacation Requests</title>

    <style> 
        <?php include __DIR__ .'/../public/style.css'; ?>
    </style>
</head>
<body>
    <div class="main-title">
        <h1>Vacation Portal</h1>
        <h2>List of Vacation Requests</h2>
    </div>
    <br>
    <a href="requestSubmitionForm.php">+ Submit New Request</a>
    
    <?php if ($result->num_rows === 0): ?>
        <h2>No vacation requests found.</h2>
    <?php else: ?>
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
                <td><?php echo date('Y-m-d', strtotime($row['submitted_date'])); ?></td>
                <td><?php echo htmlspecialchars($row['start_date']) . ' to ' . htmlspecialchars($row['end_date']); ?></td>
                <td><?php echo countWeekdays($row['start_date'], $row['end_date']) . " days"; ?></td>
                <td><?php echo htmlspecialchars($row['reason']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
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
    <?php endif; ?>
    
    <br>
    <div class="messages">
        <?php displayMessages(); ?>
    </div>
    
    <br>
    <footer>
        <div class="logout">
            <p><?php echo getLoggedInUserInfo(); ?></p>
            <a href="logout.php">Log-Out</a>
        </div>
    </footer>
</body>
</html>
