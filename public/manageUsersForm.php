<?php
session_start();
include __DIR__ . '/../src/config.php';
include __DIR__ . '/messageHandler.php';

// Check if the user is logged in and is a manager
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "manager") {
    header("Location: index.php");
    exit();
}

// Fetch all employees from the database
$stmt = $connection->prepare("SELECT id, name, email FROM users WHERE role = 'employee'");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
</head>
<body>
    <h2>List of Employees</h2>
    <a href="createUserForm.php">Create User</a>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td>
                <a href="editUserForm.php?id=<?php echo $row['id']; ?>">Edit</a> |
                <a href="deleteUser.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    
    <br>
    <div class="messages">
        <?php displayMessages(); ?>
    </div>

    <div class = logout>
        <p>You are logged in as: <?php echo $_SESSION["user_role"]; ?></p>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
