<?php
include __DIR__ . '/../src/config.php';
include __DIR__ . '/../middleware/messageHandler.php';
include __DIR__ . '/../middleware/authCheck.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user input
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $employeeCode = $_POST['employee_code'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validate employee code (7 digits)
    if (!preg_match("/^[0-9]{7}$/", $employeeCode)) {
        addMessage("error", "Invalid Employee Code. It must be a 7-digit number.");
        header("Location: createUserForm.php");
        exit();
    }

    // Check if employee code already exists
    $stmt = $connection->prepare("SELECT employee_code FROM users WHERE employee_code = ?");
    $stmt->bind_param("i", $employeeCode);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        addMessage("error", "The employee code you have given has already been used. Please try another employee code!");
        header("Location: createUserForm.php");
        exit();
    }

    // Hash the password before saving it to the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Determine the manager code
    if ($role == 'manager') {
        // For managers, set the manager code as the employee code
        $managerCode = $employeeCode;
    } else {
        // For employees, set the manager code from the session
        if (isset($_SESSION['user_manager_code'])) {
            $managerCode = $_SESSION['user_manager_code'];
        } else {
            addMessage("error", "Manager code is missing. Please ensure you are logged in as an employee.");
            header("Location: createUserForm.php");
            exit();
        }
    }

    // Insert new user with manager code
    $stmt = $connection->prepare("INSERT INTO users (manager_code, employee_code, full_name, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissss", $managerCode, $employeeCode, $fullname, $email, $hashed_password, $role);

    if ($stmt->execute()) {
        addMessage("success", "New user created successfully!");
        header("Location: manageUsersForm.php");
        exit();
    } else {
        addMessage("error", "An error has occurred during user creation. Please try again.");
        header("Location: previousPage.php");
        exit();
    }
}
?>
