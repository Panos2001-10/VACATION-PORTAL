<?php
session_start();
include __DIR__ . '/../src/config.php';
include __DIR__ . '/messageHandler.php';

// Check if the user is logged in and is a manager
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "manager") {
    header("Location: index.php");
    exit();
}

// Check if an employee ID is provided
if (!isset($_GET['id'])) {
    echo "Invalid request.";
    exit();
}

$employee_id = $_GET['id'];

// Fetch employee details
$stmt = $connection->prepare("SELECT id, name, email, employee_code, password FROM users WHERE id = ?");
$stmt->bind_param("i", $employee_id);
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
        <input type="hidden" name="id" value="<?php echo $employee['id']; ?>">
        <label for="fullname">Full Name:</label>
        <input type="text" name="fullname" value="<?php echo htmlspecialchars($employee['name']); ?>" required>

        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($employee['email']); ?>" required>
        
        <br>
        <input type="hidden" name="employee_code" value="<?php echo htmlspecialchars($employee['employee_code']); ?>" pattern="\d{7}" required>
        
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
</body>
</html>
