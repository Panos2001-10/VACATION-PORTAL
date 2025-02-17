<?php
// Include required files
include __DIR__ . '/../src/config.php'; // Database connection
include __DIR__ . '/../middleware/messageHandler.php'; // Handles notifications/messages
include __DIR__ . '/../middleware/authCheck.php'; // Ensures authentication where required
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log-in/Register - Vacation Portal</title>
    
    <style>
        <?php include __DIR__ . '/../public/style.css'; // Include external CSS file ?>
    </style>
</head>
<body>

    <!-- Page Title -->
    <div class="main-title">
        <h1>Welcome to Vacation Portal</h1>
        <h2>Log-In</h2>
    </div>
    
    <!-- Login Form -->
    <div>
        <form action="login.php" method="POST">
            <!-- Email Input -->
            <label>Email:</label>
            <input type="email" name="email" required>

            <!-- Password Input -->
            <label>Password:</label>
            <input type="password" name="password" required>

            <!-- Submit Button -->
            <button type="submit">Log-in</button>
        </form>
    </div>

    <br>

    <!-- Display Success/Error Messages -->
    <div class="messages">
        <?php displayMessages(); ?>
    </div>

</body>
</html>
