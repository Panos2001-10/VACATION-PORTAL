<?php
include __DIR__ . '/../src/config.php';
include __DIR__ . '/../middleware/messageHandler.php';
include __DIR__ . '/../middleware/authCheck.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log-in/Register - Vacation Portal</title>
    <style>
        <?php include __DIR__ .'/../public/style.css'; ?>
    </style>
</head>
<body>
    <div class="main-title">
        <h1>Welcome to Vacation Portal</h1>
        <h2>Log-In</h2>
    </div>
    
    <div>
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
