<?php
include __DIR__ . '/../src/config.php';
include __DIR__ . '/../src/utils.php';
include __DIR__ . '/../middleware/messageHandler.php';
include __DIR__ . '/../middleware/authCheck.php';

// Get employee_code from URL
$employee_code = $_GET['employee_code'] ?? null;

if (!$employee_code) {
    addMessage("error", "Invalid employee.");
    header("Location: manageUsersForm.php");
    exit();
}

// Get manager_code from session (logged-in manager)
$manager_code = $_SESSION['user_employee_code'];

// Fetch the employee's full name if they belong to the manager
$stmt = $connection->prepare("SELECT full_name FROM users WHERE employee_code = ? AND manager_code = ?");
$stmt->bind_param("ii", $employee_code, $manager_code);
$stmt->execute();
$employee_result = $stmt->get_result();

if ($employee_result->num_rows === 0) {
    addMessage("error", "This employee does not belong to your team.");
    header("Location: manageUsersForm.php");
    exit();
}

$employee = $employee_result->fetch_assoc();
$employee_full_name = $employee['full_name'] ?? 'Unknown Employee';

// Fetch vacation requests for this employee (who is managed by the logged-in manager)
$stmt = $connection->prepare("
    SELECT r.id, r.start_date, r.end_date, r.reason, r.status
    FROM requests r
    JOIN users u ON r.employee_code = u.employee_code
    WHERE r.employee_code = ? AND u.manager_code = ?
");
$stmt->bind_param("ii", $employee_code, $manager_code);
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
    
    <?php if ($result->num_rows === 0): ?>
        <h2>No vacation requests found for this employee.</h2>
    <?php else: ?>
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
                        <a href="manageRequests.php?id=<?php echo $row['id']; ?>&action=approved">Approve</a> |
                        <a href="manageRequests.php?id=<?php echo $row['id']; ?>&action=rejected">Reject</a>
                    <?php else: ?>
                        <em>No Actions Available</em>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>
    
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
