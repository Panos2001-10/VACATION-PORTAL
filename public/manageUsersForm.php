<?php
include __DIR__ . '/../src/config.php';
include __DIR__ . '/../middleware/messageHandler.php';
include __DIR__ . '/../middleware/authCheck.php';

// Fetch all employees who have the same manager_code as the logged-in manager
$managerCode = $_SESSION['user_employee_code']; // Assuming manager's employee code is saved in session
$stmt = $connection->prepare("SELECT employee_code, full_name, email FROM users WHERE role = 'employee' AND manager_code = ?");
$stmt->bind_param("i", $managerCode); // Bind the manager code to the query
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <style>
        <?php include __DIR__ .'/../public/style.css'; ?>
    </style>
</head>
<body>
    <div class="main-title">
        <h1>Vacation Portal</h1>
        <h2>List of Employees</h2>
    </div>
    
    <br>
    <a href="createUserForm.php">+ Create New User</a><br>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td>
                <a href="editUserForm.php?id=<?php echo $row['employee_code']; ?>">Edit</a> |
                <a href="deleteUser.php?id=<?php echo $row['employee_code']; ?>" onclick="return confirm('Are you sure?');">Delete</a> |
                <a href="manageRequestsForm.php?employee_code=<?php echo $row['employee_code']; ?>">See Vacation Requests</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    
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