<?php

require_once __DIR__ . '/../src/bootstrap.php';

use App\classes\database;
use App\classes\messageHandler;

$database   = new database();
$connection = $database->getConnection();

$managerCode = $_SESSION['user_employee_code'];

$stmt = $database->getConnection()->prepare("SELECT employee_code, full_name, email FROM users WHERE role = 'employee' AND manager_code = ?");
$stmt->bind_param("i", $managerCode);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <!-- Link to external CSS file for styling -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
<!-- Page Header -->
<div class="main-title">
    <h1>Vacation Portal</h1>
    <h2>List of Employees</h2>
</div>

<br>
<!-- Link to create a new user -->
<a href="createUserForm.php">+ Create New User</a><br>

<!-- Employee List Table -->
<table border="1">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>

    <!-- Loop through each employee row from the query result -->
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
<!-- Display any success/error messages -->
<div class="messages">
    <?php messageHandler::displayMessages(); ?>
</div>

<br>
<!-- Footer with user info and logout link -->
<footer>
    <div class="logout">
        <p><?php echo getLoggedInUserInfo(); ?></p>
        <a href="logout.php">Log-Out</a>
    </div>
</footer>
</body>
</html>
