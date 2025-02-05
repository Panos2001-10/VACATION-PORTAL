<?php
session_start(); // Start session to store user info
include __DIR__ . '/../backend/config.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture the user input
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prevent SQL Injection: Use prepared statements
    $stmt = $connection->prepare("SELECT id, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email); // "s" means string
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
            $_SESSION['login_messages'][] = ["type" => "success", "text" => "Login successful!"];
            header("Location: index.php");
            exit();
        } 
        else 
        {
            $_SESSION['login_messages'][] = ["type" => "error", "text" => "Incorrect password."];
        }
    } 
    else 
    {
        $_SESSION['login_messages'][] = ["type" => "error", "text" => "No account found with that email."];
    }

    // Redirect back to the index page to display the message
    header("Location: index.php");
    exit();
}
?>
