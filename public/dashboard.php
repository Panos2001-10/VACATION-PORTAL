<?php
session_start();
include __DIR__ . '/../src/config.php';

// Check if the user is already logged in
if (!isset($_SESSION["user_id"]) ) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <div class = logout>
        <p>You are logged in as: <?php echo $_SESSION["user_role"]; ?></p>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>