<?php
session_start();
include __DIR__ . '/../src/config.php';
include __DIR__ . '/../middleware/messageHandler.php';

// Check if the user is already logged in
if (isset($_SESSION["user_id"])) {
    $userId = $_SESSION["user_id"]; // Get the logged-in user ID
    if ($_SESSION["user_role"] == "manager") {
        header("Location: manageUsersForm.php?user_id=$userId");
        exit();
    } elseif ($_SESSION["user_role"] == "employee") {
        header("Location: requestsForm.php?user_id=$userId");
        exit();
    }
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
    <div class="messages">
        <?php displayMessages(); ?>
    </div>
</body>
</html>
