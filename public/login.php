<?php
session_start();
include __DIR__ . '/../src/config.php';
include __DIR__ . '/../middleware/messageHandler.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture the user input
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prevent SQL Injection: Use prepared statements
    $stmt = $connection->prepare("SELECT id, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if the user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password, $role);
        $stmt->fetch(); // Get the result

        // Check if the password is correct (hashed password comparison)
        if (password_verify($password, $hashed_password)) {
            // Store user data in session to track login status
            $_SESSION['user_id'] = $id;
            $_SESSION['user_role'] = $role;
            // Redirect to the correct page based on role
            if ($role == 'manager') {
                header("Location: manageUsersForm.php");
                exit();
            } elseif ($role == 'employee') {
                header("Location: vacationRequestsForm.php");
                exit();
            }
        } else {
            addMessage("error", "Incorrect password.");
        }
    } else {
        addMessage("error", "No account found with that email address.");
    }
    header("Location: index.php");
    exit();
}
?>
