<?php
include __DIR__ . '/../src/config.php';
include __DIR__ . '/../middleware/messageHandler.php';
include __DIR__ . '/../middleware/authCheck.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $employeeCode = $_POST['employee_code'];
    $password = $_POST['password'];
    $role = $_POST['role'];

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

    if (!preg_match("/^[0-9]{7}$/", $employeeCode)) {
        addMessage("error", "Invalid Employee Code. It must be a 7-digit number.");
        header("Location: createUserForm.php");
        exit();
    }

    $stmt = $connection->prepare("SELECT employee_code FROM users WHERE employee_code = ?");
    $stmt->bind_param("i", $employeeCode);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        addMessage("error", "The employee code you have given has already been used. Please try another employee code!");
        header("Location: createUserForm.php");
        exit();
    }

    $stmt->close();

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if ($role == 'manager') {
        $managerCode = $employeeCode;
    } else {
        if (isset($_SESSION['user_manager_code'])) {
            $managerCode = $_SESSION['user_manager_code'];
        } else {
            addMessage("error", "Manager code is missing. Please ensure you are logged in as an employee.");
            header("Location: createUserForm.php");
            exit();
        }
    }

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

    $stmt->close();
}
?>
