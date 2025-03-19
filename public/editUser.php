<?php
require_once __DIR__ . '/../src/bootstrap.php';

use App\classes\messageHandler;
use App\classes\database;

$database = new database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employeeCode = $_POST["id"];
    $fullname = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (!checkManagerAuthorization($database->getConnection(), $employeeCode)) {
        messageHandler::addMessage("error", "You are not authorized to edit this employee's details.");
        header("Location: manageUsersForm.php"); // Redirect back to user management page
        exit(); // Stop script execution
    }

    // Check if the new email is already in use by another user (excluding the current employee)
    $stmt = $database->getConnection()->prepare("SELECT employee_code FROM users WHERE email = ? AND employee_code != ?");
    $stmt->bind_param("si", $email, $employeeCode);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) { // If another user already has this email
        messageHandler::addMessage("error", "Email is already in use by another user.");
        header("Location: manageUsersForm.php"); // Redirect back to form
        exit();
    }

    $stmt->close(); // Close the statement

    // Prepare SQL update query
    if (!empty($password)) { // If a new password is provided
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password securely
        $stmt = $database->getConnection()->prepare("UPDATE users SET full_name = ?, email = ?, password = ? WHERE employee_code = ?");
        $stmt->bind_param("sssi", $fullname, $email, $hashed_password, $employeeCode);
    } else { // If no new password is provided, update only name and email
        $stmt = $database->getConnection()->prepare("UPDATE users SET full_name = ?, email = ? WHERE employee_code = ?");
        $stmt->bind_param("ssi", $fullname, $email, $employeeCode);
    }

    // Execute the update query
    if ($stmt->execute()) {
        messageHandler::addMessage("success", "User updated successfully!"); // Success message
        header("Location: manageUsersForm.php"); // Redirect back to user management page
        exit();
    } else {
        header("Location: manageUsers.php"); // Redirect in case of error
        exit(); // Stop further execution
    }
} else {

    messageHandler::addMessage("error", "Invalid request.");
    header("Location: manageUsersForm.php");
    exit();
}
