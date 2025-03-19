<?php
require_once __DIR__ . '/../src/bootstrap.php';

use App\classes\messageHandler;
use App\classes\database;

$database = new database();
$employee_code = $_GET['employee_code'] ?? null;

// Validate employee_code (ensure it's present)
if (!$employee_code) {
    messageHandler::addMessage("error", "Invalid employee.");
    header("Location: manageUsersForm.php");
    exit();
}

$manager_code = $_SESSION['user_employee_code'];

$stmt = $database->getConnection()->prepare("SELECT full_name FROM users WHERE employee_code = ? AND manager_code = ?");
$stmt->bind_param("ii", $employee_code, $manager_code);
$stmt->execute();
$employee_result = $stmt->get_result();

// Check if the employee belongs to the logged-in manager
if ($employee_result->num_rows === 0) {
    addMessage("error", "This employee does not belong to your team.");
    header("Location: manageUsersForm.php");
    exit();
}

$employee = $employee_result->fetch_assoc();
$employee_full_name = $employee['full_name'] ?? 'Unknown Employee';

$stmt = $database->getConnection()->prepare("
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
        <?php include __DIR__ .'/../public/style.css'; // Include CSS for styling ?>
    </style>
</head>
<body>
    <!-- Page Title -->
    <div class="main-title">
        <h1>Vacation Portal</h1>
        <h2>Vacation Requests</h2>
    </div>
    
    <br>
    <!-- Display the employee's name -->
    <h3>These requests are from: <?php echo htmlspecialchars($employee_full_name); ?></h3>
    
    <!-- If no vacation requests found, display a message -->
    <?php if ($result->num_rows === 0): ?>
        <h2>No vacation requests found for this employee.</h2>
    <?php else: ?>
        <!-- Display vacation requests in a table -->
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
                    <!-- Allow managers to approve or reject requests only if they are still pending -->
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
    <!-- Link to go back to employee management page -->
    <a href="manageUsersForm.php">Back to Employees</a>

    <br>
    <!-- Display success/error messages -->
    <div class="messages">
        <?php messageHandler::displayMessages(); ?>
    </div>
    
    <br>
    <!-- Footer section with logout link -->
    <footer>
        <div class="logout">
            <p><?php echo getLoggedInUserInfo(); ?></p>
            <a href="logout.php">Log-Out</a>
        </div>
    </footer>
</body>
</html>
