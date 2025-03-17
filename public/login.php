<?php

session_start();

require_once __DIR__ . '/../src/config.php';
require_once __DIR__ . '/../src/classes/Database.php';
require_once __DIR__ . '/../src/classes/User.php';
require_once __DIR__ . '/../middleware/MessageHandler.php';
require_once __DIR__ . '/../src/utils.php';

use App\Database;
use App\User;
use App\MessageHandler;

$database   = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$connection = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture user input
    $email    = $_POST['email']    ?? '';
    $password = $_POST['password'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        MessageHandler::addMessage('error', 'Please enter a valid email address.');
        header("Location: index.php");
        exit();
    }

    $user = User::findByEmail($connection, $email);

    if ($user && $user->verifyPassword($password)) {

        $_SESSION['user_manager_code']  = $user->getManagerCode();
        $_SESSION['user_employee_code'] = $user->getEmployeeCode();
        $_SESSION['user_full_name']     = $user->getFullName();
        $_SESSION['user_email']         = $user->getEmail();
        $_SESSION['user_role']          = $user->getRole();

        if ($user->getRole() === 'manager') {
            header("Location: manageUsersForm.php");
            exit();
        } elseif ($user->getRole() === 'employee') {
            header("Location: vacationRequestsForm.php");
            exit();
        }

    } else {
        // Invalid credentials
        MessageHandler::addMessage('error', 'Incorrect credentials.');
        header("Location: index.php");
        exit();
    }
}
