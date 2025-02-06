<?php
session_start();
include __DIR__ . '/../src/config.php'; // Include the database connection

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: manageUsers.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log-in/Register - Vacation Portal</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">

        <h2>Log-In</h2>
        
        <form action="login.php" method="POST">
            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Log-in</button>
        </form>
    </div>

    <br>

    <div class="login-messages-section">
        <?php
        // Display login-related messages
        if (isset($_SESSION['login_messages']) && !empty($_SESSION['login_messages'])) {
            foreach ($_SESSION['login_messages'] as $message) {
                $messageClass = $message['type'] === 'error' ? 'error' : 'success';
                echo "<p class='$messageClass'>" . htmlspecialchars($message['text']) . "</p>";
            }
            unset($_SESSION['login_messages']); // Clear messages after display
        }
        ?>
    </div>
</body>
</html>
