<?php
session_start(); // Start session to store user info
include __DIR__ . '/../backend/config.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user input from the registration form
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $role = $_POST['role']; // Get the selected role (Manager or Employee)

    if ($password !== $confirmPassword) {
        $_SESSION['register_messages'][] = ["type" => "error", "text" => "Passwords do not match."];
        header("Location: index.php"); // Redirect back to the index page
        exit();
    }

    // Hash the password before saving it to the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the query to insert the user into the database
    $stmt = $connection->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss",$fullname, $email, $hashed_password, $role);
    
    // Check if the query executed successfully
    if ($stmt->execute()) {
        $_SESSION['register_messages'][] = ["type" => "success", "text" => "Registration successful! Please log in."];
    } else {
        $_SESSION['register_messages'][] = ["type" => "error", "text" => "Error occurred during registration. Please try again."];
    }

    // Redirect to login page after successful registration
    header("Location: index.php");
    exit();
}
?>