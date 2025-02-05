<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome to the Vacation Portal</h1>
    <p>You are logged in as: <?php echo $_SESSION["user_role"]; ?></p>
    <a href="logout.php">Logout</a>
</body>
</html>
