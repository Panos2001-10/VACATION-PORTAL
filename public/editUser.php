<?php
// Include necessary files for database connection, utility functions, and authentication
include __DIR__ . '/../src/config.php'; // Database connection settings
include __DIR__ . '/../src/utils.php'; // Utility functions (e.g., authorization check)
include __DIR__ . '/../middleware/messageHandler.php'; // Handles success/error messages
include __DIR__ . '/../middleware/authCheck.php'; // Ensures the user is authenticated

// Check if the form is submitted via POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $employeeCode = $_POST["id"]; // Employee ID from hidden input field
    $fullname = trim($_POST["fullname"]); // Trim whitespace from full name
    $email = trim($_POST["email"]); // Trim whitespace from email
    $password = trim($_POST["password"]); // Trim whitespace from password (optional)

    // Ensure the logged-in manager has permission to edit this employee
    if (!checkManagerAuthorization($connection, $employeeCode)) {
        addMessage("error", "You are not authorized to edit this employee's details.");
        header("Location: manageUsersForm.php"); // Redirect back to user management page
        exit(); // Stop script execution
    }

    // Check if the new email is already in use by another user (excluding the current employee)
    $stmt = $connection->prepare("SELECT employee_code FROM users WHERE email = ? AND employee_code != ?");
    $stmt->bind_param("si", $email, $employeeCode);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) { // If another user already has this email
        addMessage("error", "Email is already in use by another user.");
        header("Location: manageUsersForm.php"); // Redirect back to form
        exit();
    }

    $stmt->close(); // Close the statement

    // Prepare SQL update query
    if (!empty($password)) { // If a new password is provided
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password securely
        $stmt = $connection->prepare("UPDATE users SET full_name = ?, email = ?, password = ? WHERE employee_code = ?");
        $stmt->bind_param("sssi", $fullname, $email, $hashed_password, $employeeCode);
    } else { // If no new password is provided, update only name and email
        $stmt = $connection->prepare("UPDATE users SET full_name = ?, email = ? WHERE employee_code = ?");
        $stmt->bind_param("ssi", $fullname, $email, $employeeCode);
    }

    // Execute the update query
    if ($stmt->execute()) {
        addMessage("success", "User updated successfully!"); // Success message
        header("Location: manageUsersForm.php"); // Redirect back to user management page
        exit();
    } else {
        header("Location: manageUsers.php"); // Redirect in case of error
        exit(); // Stop further execution
    }
} else {
    // If the script is accessed without submitting the form, show an error
    addMessage("error", "Invalid request.");
    header("Location: manageUsersForm.php"); // Redirect back to user management page
    exit();
}
?>
