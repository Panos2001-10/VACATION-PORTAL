<?php
session_start(); // Start session to store user info
include __DIR__ . '/../backend/config.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user input from the registration form
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Get the selected role (Manager or Employee)

    // Hash the password before saving it to the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the query to insert the user into the database
    $stmt = $connection->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss",$fullname, $email, $hashed_password, $role);
    $stmt->execute();

    // Redirect to login page after successful registration
    header("Location: index.php?message=Registration successful. Please log in.");
    exit();
}
?>