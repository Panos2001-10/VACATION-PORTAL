<?php
// Include necessary files for database connection, utilities, and authentication
include __DIR__ . '/../src/config.php'; // Database connection
include __DIR__ . '/../src/utils.php'; // Utility functions
include __DIR__ . '/../middleware/messageHandler.php'; // Handles success/error messages
include __DIR__ . '/../middleware/authCheck.php'; // Ensures user is authenticated before accessing this page

// Fetch all employees who have the same manager_code as the logged-in manager
$managerCode = $_SESSION['user_employee_code']; // Assuming the manager's employee code is stored in the session

// Prepare a SQL statement to get employees managed by the logged-in manager
$stmt = $connection->prepare("SELECT employee_code, full_name, email FROM users WHERE role = 'employee' AND manager_code = ?");
$stmt->bind_param("i", $managerCode); // Bind the manager's employee code to the query as an integer
$stmt->execute(); // Execute the SQL query
$result = $stmt->get_result(); // Get the result set of the executed query
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <style>
        <?php include __DIR__ .'/../public/style.css'; ?> /* Include the external CSS file for styling */
    </style>
</head>
<body>
    <!-- Page Header -->
    <div class="main-title">
        <h1>Vacation Portal</h1>
        <h2>List of Employees</h2>
    </div>
    
    <br>
    <!-- Link to create a new user -->
    <a href="createUserForm.php">+ Create New User</a><br>

    <!-- Display the list of employees in a table -->
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        
        <!-- Loop through each row (employee) retrieved from the database -->
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <!-- Display employee's full name -->
            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
            
            <!-- Display employee's email -->
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            
            <!-- Action links for each employee -->
            <td>
                <!-- Edit user details -->
                <a href="editUserForm.php?id=<?php echo $row['employee_code']; ?>">Edit</a> |
                
                <!-- Delete user with confirmation prompt -->
                <a href="deleteUser.php?id=<?php echo $row['employee_code']; ?>" onclick="return confirm('Are you sure?');">Delete</a> |
                
                <!-- View the vacation requests of the selected employee -->
                <a href="manageRequestsForm.php?employee_code=<?php echo $row['employee_code']; ?>">See Vacation Requests</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    
    <br>
    <!-- Display success/error messages (if any) -->
    <div class="messages">
        <?php displayMessages(); ?>
    </div>

    <br>
    <!-- Footer section -->
    <footer>
        <div class="logout">
            <p><?php echo getLoggedInUserInfo(); ?></p> <!-- Display logged-in user info -->
            <a href="logout.php">Log-Out</a> <!-- Logout link -->
        </div>
    </footer>
</body>
</html>
