<?php
include __DIR__ . '/../src/config.php';
include __DIR__ . '/../middleware/messageHandler.php';
include __DIR__ . '/../middleware/authCheck.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create User</title>
    <style>
        <?php include __DIR__ .'/../public/style.css'; ?>
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
            <input type="fullname" name="fullname" required>

            <label>Email:</label>
            <input type="email" name="email" required>
            
            <label for="employee_code">Employee Code (7 dgits):</label>
            <input type="text" name="employee_code" pattern="\d{7}" required><br>

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
            <p>You are logged in as: <?php echo $_SESSION['user_full_name'] . " (" . $_SESSION['user_role'] . ")" ?></p>
            <a href="logout.php">Log-Out</a>
        </div>
    </footer>
</body>
</html>
