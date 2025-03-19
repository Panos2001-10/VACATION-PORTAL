<?php
require_once __DIR__ . '/../src/bootstrap.php';

use App\classes\messageHandler;
use App\classes\database;

$database = new database();

$stmt = $database->getConnection()->prepare("SELECT id, employee_code, start_date, end_date, reason, status, submitted_date FROM requests WHERE employee_code = ?");
$stmt->bind_param("i", $_SESSION['user_employee_code']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  <!-- Set the character encoding to UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  <!-- Make the page mobile-responsive -->
    <title>Vacation Requests</title>  <!-- Page title -->

    <!-- Include external CSS for styling -->
    <style> 
        <?php include __DIR__ .'/../public/style.css'; ?>  /* Include styles from the public folder */ 
    </style>
</head>
<body>
    <!-- Main title section -->
    <div class="main-title">
        <h1>Vacation Portal</h1>  <!-- Main heading -->
        <h2>List of Vacation Requests</h2>  <!-- Subheading -->
    </div>
    <br>
    <!-- Link to submit a new vacation request -->
    <a href="requestSubmitionForm.php">+ Submit New Request</a>
    
    <?php if ($result->num_rows === 0): ?>  <!-- Check if there are no requests -->
        <h2>No vacation requests found.</h2>  <!-- Message if no requests are available -->
    <?php else: ?>
        <!-- Display requests in a table -->
        <table border="1">
            <tr>
                <!-- Table headers -->
                <th>Date Submitted</th>
                <th>Dates Requested</th>
                <th>Total Days (Weekdays only)</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>  <!-- Loop through each request -->
            <tr>
                <!-- Display the date the request was submitted -->
                <td><?php echo date('Y-m-d', strtotime($row['submitted_date'])); ?></td>

                <!-- Display the start and end dates of the vacation request -->
                <td><?php echo htmlspecialchars($row['start_date']) . ' to ' . htmlspecialchars($row['end_date']); ?></td>

                <!-- Display total weekdays between start and end dates -->
                <td><?php echo countWeekdays($row['start_date'], $row['end_date']) . " days"; ?></td>

                <!-- Display the reason for the vacation -->
                <td><?php echo htmlspecialchars($row['reason']); ?></td>

                <!-- Display the current status of the request -->
                <td><?php echo htmlspecialchars($row['status']); ?></td>

                <!-- Display delete option if the request is pending -->
                <td>
                    <?php if ($row['status'] === 'pending'): ?>
                        <a href="deleteRequest.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this request?');">Delete</a>
                    <?php else: ?>
                        N/A  <!-- Not available if the status is not 'pending' -->
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>
    
    <br>
    <!-- Display messages (if any) like success or error -->
    <div class="messages">
        <?php messageHandler::displayMessages(); ?>
    </div>
    
    <br>
    <!-- Footer section with logout link -->
    <footer>
        <div class="logout">
            <p><?php echo getLoggedInUserInfo(); ?></p>  <!-- Display logged-in user's information -->
            <a href="logout.php">Log-Out</a>  <!-- Link to logout -->
        </div>
    </footer>
</body>
</html>
