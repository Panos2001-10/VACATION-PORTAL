<?php
// Include necessary files for database configuration, utility functions, authentication check, and message handling
include __DIR__ . '/../src/config.php';  // Database connection
include __DIR__ . '/../src/utils.php';   // Utility functions (e.g., for calculating weekdays)
include __DIR__ . '/../middleware/authCheck.php';  // To ensure the user is authenticated
include __DIR__ . '/../middleware/messageHandler.php';  // For handling and displaying messages
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  <!-- Set the character encoding to UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  <!-- Make the page mobile-responsive -->
    <title>Vacation Request</title>  <!-- Page title -->
    <!-- Include external CSS for styling -->
    <style>
        <?php include __DIR__ .'/../public/style.css'; ?>  /* Include styles from the public folder */
    </style>
</head>
<body>
    <!-- Main title section -->
    <div class="main-title">
        <h1>Vacation Portal</h1>  <!-- Main heading -->
        <h2>Vacation Request</h2>  <!-- Subheading for the specific page -->
    </div>
    
    <br>
    <div>
        <!-- Form to submit a new vacation request -->
        <form action="requestSubmition.php" method="POST">
            
            <!-- Input for selecting start date -->
            <label for="start_date">Date from:</label>
            <input type="date" name="start_date" required>  <!-- Required field for start date -->
            
            <!-- Input for selecting end date -->
            <label for="end_date">Date to:</label>
            <input type="date" name="end_date" required>  <!-- Required field for end date -->
            
            <!-- Textarea for specifying the reason for the vacation -->
            <label for="reason">Reason:</label>
            <br>
            <textarea name="reason" rows="6" cols="50" required></textarea>  <!-- Required field for reason -->
            <br>

            <!-- Submit button to save the request -->
            <button type="submit">Save</button>

            <br>
            <!-- Back link to return to the vacation requests page -->
            <div style="text-align: right; margin-top: 10px;">
                <a href="vacationRequestsForm.php">Back to Requests</a>  <!-- Link to the vacation requests page -->
            </div>
        </form>
    </div>

    <br>
    <!-- Display messages (like success or error messages) -->
    <div class="messages">
        <?php displayMessages(); ?>  <!-- Function to display messages to the user -->
    </div>

    <br>
    <!-- Footer section with logout link -->
    <footer>
        <div class="logout">
            <p><?php echo getLoggedInUserInfo(); ?></p>  <!-- Display logged-in user's information -->
            <a href="logout.php">Log-Out</a>  <!-- Link to logout -->
        </div>
    </footer>
</body>
</html>
