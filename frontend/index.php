<?php
session_start();
include __DIR__ . '/../backend/config.php'; // Include the database connection

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Vacation Portal</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <!-- Display Database Connection Message -->
        <?php 
        if (isset($_SESSION['db_message'])) 
        { 
            echo "<p class='db-message'>" . htmlspecialchars($_SESSION['db_message']) . "</p>"; 
            unset($_SESSION['db_message']); // Remove message after displaying
        }
        ?>

        <h2>Log-In</h2>

        <?php 
        if (isset($_GET['error'])) 
        { 
            echo "<p class='error'>" . htmlspecialchars($_GET['error']) . "</p>"; 
        } 
        ?>
        
        <form action="login.php" method="POST">
            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Log-in</button>
        </form>
    </div>

    <br>

    <div class =register-container>
    <h2>Register</h2>
        <!-- HTML Form for registration -->
        <form action="register.php" method="POST">
            <label>Full Name:</label>
            <input type="fullname" name="fullname" required>

            <label>Email:</label>
            <input type="email" name="email" required>
            
            <label>Password:</label>
            <input type="password" name="password" required>
            
            <label>Confirm password:</label>
            <input type="password" name="confirmPassword" required>
            
            <br>
            <label>Role:</label>
            <div>
                <input type="radio" id="manager" name="role" value="manager" required>
                <label for="manager">Manager</label>

                <input type="radio" id="employee" name="role" value="employee" required>
                <label for="employee">Employee</label>
            </div>

            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
