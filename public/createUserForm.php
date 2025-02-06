<?php
session_start();
include __DIR__ . '/../src/config.php';
include __DIR__ . '/messageHandler.php';

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
        
        <label for="employee_code">Employee Code (7 dgits):</label>
        <input type="text" name="employee_code" pattern="\d{7}" required><br>

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
    <div class="messages">
        <?php displayMessages(); ?>
    </div>

    <div class = logout>
        <p>You are logged in as: <?php echo $_SESSION["user_role"]; ?></p>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
