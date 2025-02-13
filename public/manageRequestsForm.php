<?php
include __DIR__ . '/../src/config.php';
include __DIR__ . '/../middleware/messageHandler.php';
include __DIR__ . '/../middleware/authCheck.php';
include __DIR__ . '/../middleware/utils.php';

// Get employee_code from URL
$employee_code = $_GET['employee_code'] ?? null;

if (!$employee_code) {
    addMessage("error", "Invalid employee.");
    header("Location: manageUsersForm.php");
    exit();
}

// Fetch the employee's full name
$stmt = $connection->prepare("SELECT full_name FROM users WHERE employee_code = ?");
$stmt->bind_param("i", $employee_code);
$stmt->execute();
$employee_result = $stmt->get_result();
$employee = $employee_result->fetch_assoc();
$employee_full_name = $employee['full_name'] ?? 'Unknown Employee';

// Fetch vacation requests
$stmt = $connection->prepare("SELECT id, start_date, end_date, reason, status FROM requests WHERE employee_code = ?");
$stmt->bind_param("i", $employee_code);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Vacation Requests</title>
    <style>
        <?php include __DIR__ .'/../public/style.css'; ?>
    </style>
</head>
<body>
    <div class="main-title">
        <h1>Vacation Portal</h1>
        <h2>Vacation Requests</h2>
    </div>
    
    <br>
    <h3>These requests are from: <?php echo htmlspecialchars($employee_full_name); ?></h3>
    <table border="1">
        <tr>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Total Days</th>
            <th>Reason</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['start_date']); ?></td>
            <td><?php echo htmlspecialchars($row['end_date']); ?></td>
            <td><?php echo countWeekdays($row['start_date'], $row['end_date']) . " days"; ?></td>
            <td><?php echo htmlspecialchars($row['reason']); ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
            <td>
                <?php if ($row['status'] === 'pending'): ?>
                    <a href="manageRequets.php?id=<?php echo $row['id']; ?>&action=approved">Approve</a> |
                    <a href="manageRequets.php?id=<?php echo $row['id']; ?>&action=rejected">Reject</a>
                <?php else: ?>
                    <em>No Actions Available</em>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    
    <br>
    <a href="manageUsersForm.php">Back to Employees</a>

    <br>
    <div class="messages">
        <?php displayMessages(); ?>
    </div>
    
    <br>
    <footer>
        <div class="logout">
            <p>You are logged in as: <?php echo $_SESSION['user_full_name'] . " (" . $_SESSION['user_role'] . ")" ?></p>
            <a href="logout.php">Log-Out</a>
        </div>
    </footer>
</body>
</html>
