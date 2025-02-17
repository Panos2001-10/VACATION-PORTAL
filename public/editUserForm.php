<?php
// Include necessary files for database connection, utility functions, and authentication
include __DIR__ . '/../src/config.php'; // Database connection settings
include __DIR__ . '/../src/utils.php'; // Utility functions
include __DIR__ . '/../middleware/messageHandler.php'; // Handles success/error messages
include __DIR__ . '/../middleware/authCheck.php'; // Ensures user is authenticated before accessing this page

// Check if an employee ID is provided in the URL
if (!isset($_GET['id'])) {
    echo "Invalid request."; // Display error if no ID is provided
    exit(); // Stop script execution
}

// Get the employee ID from the URL parameter
$employeeCode = $_GET['id'];

// Ensure the logged-in manager has permission to edit this employee
if (!checkManagerAuthorization($connection, $employeeCode)) {
    addMessage("error", "You are not authorized to edit this employee's details.");
    header("Location: manageUsersForm.php"); // Redirect back to user management page
    exit(); // Stop script execution
}

// Prepare SQL query to fetch employee details based on the provided ID
$stmt = $connection->prepare("SELECT employee_code, full_name, email, password FROM users WHERE employee_code = ?");
$stmt->bind_param("i", $employeeCode); // Bind employee ID as an integer
$stmt->execute(); // Execute the query
$result = $stmt->get_result(); // Get query result
$employee = $result->fetch_assoc(); // Fetch employee details as an associative array

// Check if employee exists in the database
if (!$employee) {
    echo "Employee not found."; // Show error message if no record found
    exit(); // Stop script execution
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
        <?php displayMessages(); ?>
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
