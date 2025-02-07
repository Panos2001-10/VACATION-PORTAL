<?php
session_start();

include __DIR__ . '/../src/config.php';
include __DIR__ . '/../middleware/messageHandler.php';
include __DIR__ . '/../middleware/authCheck.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user input from the registration form
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $employeeCode = $_POST['employee_code'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validate employee code (7 digits)
    if (!preg_match("/^[0-9]{7}$/", $employeeCode)) {
        addMessage("error", "Invalid Employee Code. It must be a 7-digit number.");
        header("Location: previousPage.php");
        exit();
    }

    // Hash the password before saving it to the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the query to insert the user into the database
    $stmt = $connection->prepare("INSERT INTO users (name, email, employee_code, password, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss",$fullname, $email, $employeeCode, $hashed_password, $role);
    
    // Check if the query executed successfully
    if ($stmt->execute()) {
        addMessage("success", "New user created successfully!");
    } else {
        addMessage("error", "An error has occurred during user creation. Please try again.");
    }

    // Redirect to login page after successful registration
    header("Location: manageUsersForm.php");
    exit();
}
?>