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
    <div class="main-title">
        <h1>Vacation Portal</h1>
        <h2>Create New User</h2>
    </div>
    
    <br>
    <div>
        <form action="createUser.php" method="POST"> 
            <label>Full Name:</label>
            <input type="text" name="fullname" required>

            <label>Email:</label>
            <input type="email" name="email" required>
            
            <label for="employee_code">Employee Code (7 digits):</label>
            <input type="text" name="employee_code" pattern="\d{7}" required>
            <br>

            <label>Password:</label>
            <input type="password" name="password" required>

            <br>
            <label>Role:</label>
            <div class="role-selection">
                <input type="radio" id="manager" name="role" value="manager" required>
                <label for="manager">Manager</label>

                <input type="radio" id="employee" name="role" value="employee" required>
                <label for="employee">Employee</label>
            </div>

            <button type="submit">Create New User</button>

            <br>
            <div style="text-align: right; margin-top: 10px;">
                <a href="manageUsersForm.php">Back to Employees</a>
            </div>
        </form>
    </div>

    <br>
    <div class="messages">
        <?php displayMessages(); ?>
    </div>

    <br>
    <footer>
        <div class="logout">
            <p><?php echo getLoggedInUserInfo(); ?></p>
            <a href="logout.php">Log-Out</a>
        </div>
    </footer>
</body>
</html>
