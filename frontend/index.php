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

        <h2>Login</h2>

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
</body>
</html>
