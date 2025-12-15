<?php
session_start();

include __DIR__ . '/../src/config.php';
include __DIR__ . '/../src/utils.php';
include __DIR__ . '/../middleware/messageHandler.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL Injection
    $stmt = $connection->prepare("SELECT manager_code, employee_code, full_name, email, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($managerCode, $employeeCode, $fullName, $userEmail, $hashed_password, $role);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            deleteExpiredRequests($connection);

            $_SESSION['user_manager_code'] = $managerCode;
            $_SESSION['user_employee_code'] = $employeeCode;
            $_SESSION['user_full_name'] = $fullName;
            $_SESSION['user_email'] = $userEmail;
            $_SESSION['user_role'] = $role;

            if ($role == 'manager') {
                header("Location: manageUsersForm.php");
                exit();
            } elseif ($role == 'employee') {
                header("Location: vacationRequestsForm.php");
                exit();
            }
        } else {
            addMessage("error", "Incorrect credentials.");
        }
    } else {
        addMessage("error", "Incorrect credentials.");
    }

    header("Location: index.php");
    exit();
}
?>
