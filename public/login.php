<?php
// Start a session to store user data after login
session_start();

// Include necessary files
include __DIR__ . '/../src/config.php'; // Database connection
include __DIR__ . '/../src/utils.php';  // Utility functions
include __DIR__ . '/../middleware/messageHandler.php'; // Handles success/error messages

// Check if the form is submitted via POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture user input from the login form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL Injection
    $stmt = $connection->prepare("SELECT manager_code, employee_code, full_name, email, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if the user exists in the database
    if ($stmt->num_rows > 0) {
        // Bind the result to variables
        $stmt->bind_result($managerCode, $employeeCode, $fullName, $userEmail, $hashed_password, $role);
        $stmt->fetch(); // Retrieve the result

        // Verify the entered password against the hashed password in the database
        if (password_verify($password, $hashed_password)) {
            // Clean up expired vacation requests (if applicable)
            deleteExpiredRequests($connection);

            // Store user details in session (excluding password for security)
            $_SESSION['user_manager_code'] = $managerCode;
            $_SESSION['user_employee_code'] = $employeeCode;
            $_SESSION['user_full_name'] = $fullName;
            $_SESSION['user_email'] = $userEmail;
            $_SESSION['user_role'] = $role;

            // Redirect user based on their role
            if ($role == 'manager') {
                header("Location: manageUsersForm.php"); // Redirect managers to user management
                exit();
            } elseif ($role == 'employee') {
                header("Location: vacationRequestsForm.php"); // Redirect employees to vacation requests
                exit();
            }
        } else {
            // Incorrect password error message
            addMessage("error", "Incorrect credentials.");
        }
    } else {
        // User not found error message
        addMessage("error", "Incorrect credentials.");
    }

    // Redirect back to the login page with an error message
    header("Location: index.php");
    exit();
}
?>
