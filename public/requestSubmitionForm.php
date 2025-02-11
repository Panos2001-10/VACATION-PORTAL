<?php
include __DIR__ . '/../src/config.php';
include __DIR__ . '/../middleware/authCheck.php';
include __DIR__ . '/../middleware/messageHandler.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vacation Request</title>
</head>
<body>
    <h2>Vacation Request</h2>
    <a href="vacationRequestsForm.php">Back to vacation requests</a><br>

    <form action="requestSubmition.php" method="POST">
        <label for="start_date">Date from:</label>
        <input type="date" name="start_date" required>
        
        <label for="end_date">Date to:</label>
        <input type="date" name="end_date" required>
        
        <label for="reason">Reason:</label>
        <textarea name="reason" required></textarea>
        
        <button type="submit">Save</button>
    </form>
    
    <div class="messages">
        <?php displayMessages(); ?>
    </div>

    <br>
    <div class="logout">
        <p>You are logged in as: <?php echo $_SESSION['user_full_name'], ", ", $_SESSION['user_role']?></p>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
