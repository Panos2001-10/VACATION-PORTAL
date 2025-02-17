<?php
// Include necessary files for database connection, utility functions, and authentication
include __DIR__ . '/../src/config.php'; // Database connection settings
include __DIR__ . '/../src/utils.php'; // Utility functions
include __DIR__ . '/../middleware/messageHandler.php'; // Handles success/error messages
include __DIR__ . '/../middleware/authCheck.php'; // Ensures the user is authenticated
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create User</title>
    <style>
        <?php include __DIR__ . '/../public/style.css'; // Include external stylesheet ?>
    </style>
</head>
<body>
    <!-- Page Title -->
    <div class="main-title">
        <h1>Vacation Portal</h1>
        <h2>Create New User</h2>
    </div>
    
    <br>
    <div>
        <!-- User Creation Form -->
        <form action="createUser.php" method="POST"> 
            <!-- Full Name Input Field -->
            <label>Full Name:</label>
            <input type="text" name="fullname" required> <!-- Required field to prevent empty submission -->

            <!-- Email Input Field -->
            <label>Email:</label>
            <input type="email" name="email" required> <!-- Uses HTML5 validation for email format -->
            
            <!-- Employee Code Input Field (7-digit numeric validation) -->
            <label for="employee_code">Employee Code (7 digits):</label>
            <input type="text" name="employee_code" pattern="\d{7}" required> <!-- Enforces exactly 7-digit numbers -->
            <br>

            <!-- Password Input Field -->
            <label>Password:</label>
            <input type="password" name="password" required> <!-- Required password field -->

            <br>
            <!-- Role Selection (Manager or Employee) -->
            <label>Role:</label>
            <div class="role-selection">
                <input type="radio" id="manager" name="role" value="manager" required> <!-- Manager option -->
                <label for="manager">Manager</label>

                <input type="radio" id="employee" name="role" value="employee" required> <!-- Employee option -->
                <label for="employee">Employee</label>
            </div>

            <!-- Submit Button -->
            <button type="submit">Create New User</button>

            <br>
            <!-- Back to Employees List Link -->
            <div style="text-align: right; margin-top: 10px;">
                <a href="manageUsersForm.php">Back to Employees</a>
            </div>
        </form>
    </div>

    <br>
    <!-- Display Messages (Success/Error Notifications) -->
    <div class="messages">
        <?php displayMessages(); ?>
    </div>

    <br>
    <!-- Footer Section -->
    <footer>
        <div class="logout">
            <p><?php echo getLoggedInUserInfo(); // Display logged-in user info ?></p>
            <a href="logout.php">Log-Out</a> <!-- Logout link -->
        </div>
    </footer>
</body>
</html>
