<?php
require_once __DIR__ . '/../src/bootstrap.php';

use App\classes\messageHandler;
use App\classes\database;

$database = new database();

if (!isset($_GET['id'])) {
    echo "Invalid request.";
    exit();
}

$employeeCode = $_GET['id'];

if (!checkManagerAuthorization($database->getConnection(), $employeeCode)) {
    messageHandler::addMessage("error", "You are not authorized to edit this employee's details.");
    header("Location: manageUsersForm.php");
    exit();
}

$stmt = $database->getConnection()->prepare("SELECT employee_code, full_name, email, password FROM users WHERE employee_code = ?");
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
    <style>
        <?php include __DIR__ .'/../public/style.css'; ?> /* Include the external CSS file for styling */
    </style>
</head>
<body>
    <!-- Page Header -->
    <div class="main-title">
        <h1>Vacation Portal</h1>
        <h2>Edit Employee</h2>
    </div>
    
    <br>
    <!-- Form for editing employee details -->
    <form action="editUser.php" method="POST">
        <!-- Hidden field to store employee ID (required for updating record) -->
        <input type="hidden" name="id" value="<?php echo $employee['employee_code']; ?>">
        
        <!-- Full Name Input Field -->
        <label for="fullname">Full Name:</label>
        <input type="text" name="fullname" value="<?php echo htmlspecialchars($employee['full_name']); ?>" required>
        
        <br>
        <!-- Email Input Field -->
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($employee['email']); ?>" required>
        
        <br>
        <!-- Password Input Field (optional) -->
        <label for="password">New Password (leave blank to keep current password):</label>
        <input type="password" name="password">
        <br>
        
        <br>
        <!-- Submit button to save changes -->
        <button type="submit">Save Changes</button>
        
        <br>
        <!-- Link to navigate back to employee management page -->
        <div style="text-align: right; margin-top: 10px;">
            <a href="manageUsersForm.php">Back to Employees</a>
        </div>
    </form>

    <br>
    <!-- Display success/error messages (if any) -->
    <div class="messages">
        <?php messageHandler::displayMessages(); ?>
    </div>

    <br>
    <!-- Footer section -->
    <footer>
        <div class="logout">
            <p><?php echo getLoggedInUserInfo(); ?></p> <!-- Display logged-in user info -->
            <a href="logout.php">Log-Out</a> <!-- Logout link -->
        </div>
    </footer>
</body>
</html>
