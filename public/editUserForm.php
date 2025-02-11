<?php
include __DIR__ . '/../src/config.php';
include __DIR__ . '/../middleware/messageHandler.php';
include __DIR__ . '/../middleware/authCheck.php';

// Check if an employee ID is provided
if (!isset($_GET['id'])) {
    echo "Invalid request.";
    exit();
}

$employeeCode = $_GET['id'];

// Fetch employee details
$stmt = $connection->prepare("SELECT employee_code, full_name, email, password FROM users WHERE employee_code = ?");
$stmt->bind_param("i", $employeeCode);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();

if (!$employee) {
    echo "Employee not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
</head>
<body>
    <h2>Edit Employee</h2>
    <form action="editUser.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $employee['employee_code']; ?>">

        <label for="fullname">Full Name:</label>
        <input type="text" name="fullname" value="<?php echo htmlspecialchars($employee['full_name']); ?>" required>

        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($employee['email']); ?>" required>
        
        <br>
        <label for="password">New Password (leave blank to keep current password):</label>
        <input type="password" name="password">
        
        <br>
        <button type="submit">Save Changes</button>
    </form>
    <br>
    <div class="messages">
        <?php displayMessages(); ?>
    </div>

    <br>
    <br>
    <div class="logout">
        <p>You are logged in as: <?php echo $_SESSION['user_full_name'], ", ", $_SESSION['user_role']?></p>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
