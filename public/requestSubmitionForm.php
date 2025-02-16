<?php
include __DIR__ . '/../src/config.php';
include __DIR__ . '/../src/utils.php';
include __DIR__ . '/../middleware/authCheck.php';
include __DIR__ . '/../middleware/messageHandler.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vacation Request</title>
    <style>
        <?php include __DIR__ .'/../public/style.css'; ?>
    </style>
</head>
<body>
    <div class="main-title">
        <h1>Vacation Portal</h1>
        <h2>Vacation Request</h2>
    </div>
    
    <br>
    <div>
        <form action="requestSubmition.php" method="POST">
            <label for="start_date">Date from:</label>
            <input type="date" name="start_date" required>
            
            <label for="end_date">Date to:</label>
            <input type="date" name="end_date" required>
            
            <label for="reason">Reason:</label>
            <br>
            <textarea name="reason" rows="6" cols="50" required></textarea>
            <br>

            <br>
            <button type="submit">Save</button>

            <br>
            <div style="text-align: right; margin-top: 10px;">
                <a href="vacationRequestsForm.php">Back to Requests</a>
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
            <p><?php echo getLoggedInUserInfo(); ?></p>
            <a href="logout.php">Log-Out</a>
        </div>
    </footer>
</body>
</html>
