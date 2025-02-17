<?php
// Include necessary files for database connection, authentication, and message handling
include __DIR__ . '/../src/config.php'; // Database connection settings
include __DIR__ . '/../middleware/messageHandler.php'; // Handles success/error messages
include __DIR__ . '/../middleware/authCheck.php'; // Ensures the user is authenticated

// Check if the request method is POST (form submission)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user input from the form
    $fullname = $_POST['fullname']; // User's full name
    $email = $_POST['email']; // Email address
    $employeeCode = $_POST['employee_code']; // Employee code (must be 7 digits)
    $password = $_POST['password']; // User's password
    $role = $_POST['role']; // Role (manager or employee)

    /** 
     * === FULL NAME VALIDATION ===
     * - Ensure the full name is not empty.
     * - Allow only letters, spaces, hyphens, and apostrophes.
     * - Enforce length between 3 and 100 characters.
     */
    if (empty($fullname)) {
        addMessage("error", "Full Name is required.");
        header("Location: createUserForm.php");
        exit();
    } elseif (!preg_match("/^[a-zA-Z\s\-']+$/", $fullname)) {
        addMessage("error", "Full Name must only contain letters, spaces, hyphens, and apostrophes.");
        header("Location: createUserForm.php");
        exit();
    } elseif (strlen($fullname) < 3 || strlen($fullname) > 100) {
        addMessage("error", "Full Name must be between 3 and 100 characters long.");
        header("Location: createUserForm.php");
        exit();
    }

    /** 
     * === EMPLOYEE CODE VALIDATION ===
     * - Ensure the employee code consists of exactly 7 digits.
     */
    if (!preg_match("/^[0-9]{7}$/", $employeeCode)) {
        addMessage("error", "Invalid Employee Code. It must be a 7-digit number.");
        header("Location: createUserForm.php");
        exit();
    }

    /** 
     * === CHECK IF EMPLOYEE CODE ALREADY EXISTS ===
     * - Prevent duplicate employee codes in the database.
     */
    $stmt = $connection->prepare("SELECT employee_code FROM users WHERE employee_code = ?");
    $stmt->bind_param("i", $employeeCode);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        addMessage("error", "The employee code you have given has already been used. Please try another employee code!");
        header("Location: createUserForm.php");
        exit();
    }

    // Close the statement
    $stmt->close();

    /** 
     * === PASSWORD HASHING ===
     * - Encrypt the password before storing it in the database for security.
     */
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    /** 
     * === ASSIGN MANAGER CODE ===
     * - If the new user is a manager, set their manager code as their own employee code.
     * - If the new user is an employee, assign the manager code from the logged-in user's session.
     */
    if ($role == 'manager') {
        $managerCode = $employeeCode; // Managers use their own employee code as the manager code
    } else {
        // Ensure the session contains a valid manager code before assigning it to the new employee
        if (isset($_SESSION['user_manager_code'])) {
            $managerCode = $_SESSION['user_manager_code'];
        } else {
            addMessage("error", "Manager code is missing. Please ensure you are logged in as an employee.");
            header("Location: createUserForm.php");
            exit();
        }
    }

    /** 
     * === INSERT NEW USER INTO DATABASE ===
     * - Store the new user's details, including the assigned manager code.
     */
    $stmt = $connection->prepare("INSERT INTO users (manager_code, employee_code, full_name, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissss", $managerCode, $employeeCode, $fullname, $email, $hashed_password, $role);

    if ($stmt->execute()) {
        addMessage("success", "New user created successfully!");
        header("Location: manageUsersForm.php"); // Redirect to user management page
        exit();
    } else {
        addMessage("error", "An error has occurred during user creation. Please try again.");
        header("Location: previousPage.php"); // Redirect back to the previous page
        exit();
    }

    // Close the statement
    $stmt->close();
}
?>
