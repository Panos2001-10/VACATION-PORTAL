<?php
session_start();
include __DIR__ . '/../src/config.php'; // Include the database connection

// Check if the user is already logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create User</title>
</head>
<body>
    <h1>Welcome to the Vacation Portal</h1>
    <div class =register-container>

    <h2>Register</h2> 

    <form action="createUser.php" method="POST">
        <label>Full Name:</label>
        <input type="fullname" name="fullname" required>

        <label>Email:</label>
        <input type="email" name="email" required>
        
        <label>Password:</label>
        <input type="password" name="password" required>

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

    <br>

    <div class="register-messages-section">
        <?php
        // Display register-related messages
        if (isset($_SESSION['register_messages']) && !empty($_SESSION['register_messages'])) {
            foreach ($_SESSION['register_messages'] as $message) {
                $messageClass = $message['type'] === 'error' ? 'error' : 'success';
                echo "<p class='$messageClass'>" . htmlspecialchars($message['text']) . "</p>";
            }
            unset($_SESSION['register_messages']); // Clear messages after display
        }
        ?>
    </div>
    <div class = logout>
        <p>You are logged in as: <?php echo $_SESSION["user_role"]; ?></p>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
